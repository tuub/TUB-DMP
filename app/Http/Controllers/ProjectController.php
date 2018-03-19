<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\ImportProjectRequest;
use App\Project;
use App\DataSource;
use App\Template;
use Illuminate\Http\Request;
use Mail;
use App\Library\Sanitizer;
use App\Library\Notification;

class ProjectController extends Controller
{
    protected $project;
    protected $data_source;

    /**
     * ProjectController constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project, DataSource $data_source)
    {
        $this->project = $project;
        $this->data_source = $data_source;
    }


    /**
     * Collects hierarchical project data with various relations and counts,
     * and passes them to the dashboard. No dashboard without this method.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = $this->project
                    ->with('user', 'plans', 'data_source', 'plans.survey', 'plans.survey.template',
                        'metadata', 'metadata.metadata_registry', 'metadata.metadata_registry.content_type')
                    ->withCount('plans')
                    ->withCount('children')
                    ->where([
                        'user_id' => auth()->user()->id,
                        'is_active' => true,
                    ])
                    ->orderBy('updated_at', 'desc')
                    ->get()
                    ->toHierarchy();

        // For Modals
        $templates = Template::active()->get();

        return view('dashboard', compact('projects', 'templates'));
    }


    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $project = $this->project->with('metadata.metadata_registry')->findOrFail($id);
            if ($project) {
                return $project->toJson();
            }
        }

        return abort(403, 'Direct access is not allowed.');
    }


    /**
     * Receives request from edit project form (modal) and passes the data to
     * the intermediate method saveMetadata() in project model.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request)
    {
        if($request->ajax()) {

            /* Clean input */
            $dirty = new Sanitizer($request);
            $remove = ['id', '_token', '_method'];
            $data = $dirty->cleanUp($remove);

            /* The validation */

            /* Get object */
            $project = $this->project->findOrFail($request->id);

            /* The operation */
            $op = $project->saveMetadata($data);

            /* Notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully updated the project metadata!', 'success');
            } else {
                $notification = new Notification(500, 'Error while updating the project metadata!', 'error');
            }

            return $notification->toJson($request);
        }

        return abort(403, 'Direct access is not allowed.');
    }


    public function import(ImportProjectRequest $request)
    {
        if($request->ajax()) {

            /* Clean input */
            $dirty = new Sanitizer($request);
            $data = $dirty->cleanUp();

            /* The validation */

            /* Get object */
            $project = $this->project->findOrFail($request->id);

            /* The operation */
            $op = $project->importFromDataSource();

            /* Notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully imported the project metadata!', 'success');
            } else {
                $notification = new Notification(500, 'Error while importing the project metadata!', 'error');
            }

            return $notification->toJson($request);
        }

        return abort(403, 'Direct access is not allowed.');
    }


    public function request(RequestProjectRequest $request)
    {
        if ($request->ajax()) {

            /* Clean input */
            $dirty = new Sanitizer($request);
            $data = $dirty->cleanUp();
    
            /* The validation */

            /* Prepare data */

            // If valid TUB identifier, set data_source to to DEFAULT_DATASOURCE,
            // If not, generate random identifier and leave data_source to NULL
            if ($this->project->isValidIdentifier($data['identifier'])) {
                $data['data_source_id'] = $this->data_source->getByIdentifier(env('PROJECT_DEFAULT_DATASOURCE'));
            } else {
                $data['identifier'] = $this->project->generateRandomIdentifier();
            }

            // In Demo Mode, auto-approve all projects
            env('DEMO_MODE') ? $data['is_active'] = true : $data['is_active'] = false;

            /* The operation */
            // FIXME: If child project then create the big one as well (if not present!)
            $op = $new_project = $this->project->create($data);

            /* The mail */
            Mail::send( [ 'text' => 'emails.project.request' ], [ 'project' => $data ],
                function ( $message ) use ( $data ) {
                    $subject = 'TUB-DMP Project Request';
                    $message->from( env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP') );
                    $message->to( env('ADMIN_MAIL_ADDRESS', 'root@localhost'), env('ADMIN_NAME', 'TUB-DMP Administrator') )->subject( $subject );
                    $message->replyTo( $data['email'], $data['name'] );
                }
            );

            /* Notification */
            if (Mail::failures()) {
                $notification = new Notification(500, 'Error while sending the project request!', 'error');
            } else {
                if ($op) {
                    $notification = new Notification(200, 'Successfully requested the project!', 'success');
                } else {
                    $notification = new Notification(500, 'Error while requesting the project!', 'error');
                }
            }

            return $notification->toJson($request);
        }

        return abort(403, 'Direct access is not allowed.');
    }
}
