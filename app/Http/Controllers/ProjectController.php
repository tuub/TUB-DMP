<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProjectRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\CreateProjectRequest;
use App\MetadataRegistry;
use App\Project;
use App\Question;
use App\Template;
use Request;
use Mail;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    protected $project;


    /**
     * ProjectController constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
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


    public function show($id)
    {
        $project = $this->project->with('metadata.metadata_registry')->findOrFail($id);
        if( $project) {
            if (Request::ajax()) {
                return $project->toJson();
            } else {
                abort(403, 'Direct access is not allowed.');
            }
        } else {
            throw new NotFoundHttpException;
        }
    }


    /**
     * Receives request from edit project form (modal) and passes the data to
     * the intermediate method saveMetadata() in project model.
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request)
    {
        /* Get the project instance */
        $project = $this->project->findOrFail($request->id);

        /* Get the request data while kicking out non-metadata values */
        $data = $request->except(['_token', '_method', 'id']);

        /* Save the metadata (or not) and assign response variables */
        if ($project->saveMetadata($data)) {
            $notification = [
                'status'     => 200,
                'message'    => 'Project Metadata was successfully updated!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status'     => 500,
                'message'    => 'Project Metadata not updated!',
                'alert-type' => 'error'
            ];
        };

        /* Send the response*/
        if($request->ajax()) {

            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);

            return response()->json([
                'response' => $notification['status'],
                'message'  => $notification['message']
            ]);

        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }


    public function import(ImportProjectRequest $request)
    {
        /* Get the project instance */
        $project = $this->project->findOrFail($request->id);

        /* Import the metadata (or not) and assign response variables */
        if ($project->importFromDataSource()) {
            $notification = [
                'status' => 200,
                'message' => 'Data import successfull!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Data import not successfull!',
                'alert-type' => 'error'
            ];
        };

        /* Send the response*/
        if($request->ajax()) {

            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);

            return response()->json([
                'response' => $notification['status'],
                'message'  => $notification['message']
            ]);

        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }


    public function testImport(ProjectRequest $request)
    {
        /* Get the project instance */
        $project = $this->project->findOrFail($request->id);

        /* Import the metadata (or not) and assign response variables */
        $project->testImportFromDataSource();
    }


    public function request(CreateProjectRequest $request)
    {
        if (Request::ajax()) {

            $project['user_id'] = $request->get('user_id');
            $project['identifier'] = $request->get( 'identifier' );
            $project['name'] = $request->get( 'name' );
            $project['email'] = $request->get( 'email' );
            $project['tub_om'] = $request->get( 'tub_om' );
            $project['institution_identifier'] = $request->get( 'institution_identifier' );
            $project['contact_email'] = $request->get( 'contact_email' );
            $project['message'] = $request->get( 'message' );

            $project['is_active'] = false;

            // FIXME: If child project then create the big one as well (if not present!)

            $new_project = $this->project->create($project);

            // FIXME: Throw exception when Project::generateRandomIdentifier() returns NULL

            if (!$new_project->hasValidIdentifier()) {
                $new_project->identifier = Project::generateRandomIdentifier();
                $new_project->save();
            }

            Mail::send( [ 'text' => 'emails.project.request' ], [ 'project' => $project ],
                function ( $message ) use ( $project ) {
                    $subject = 'TUB-DMP Project Request';
                    $message->from( env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP') );
                    $message->to( env('ADMIN_MAIL_ADDRESS', 'root@localhost'), env('ADMIN_NAME', 'TUB-DMP Administrator') )->subject( $subject );
                    $message->replyTo( $project['email'], $project['name'] );
                }
            );

            if (Mail::failures()) {
                $notification = [
                    'status' => 500,
                    'message' => 'Project request was not sent successfully!',
                    'alert-type' => 'error'
                ];
            } else {
                $notification = [
                    'status' => 200,
                    'message' => 'Project request was sent successfully!',
                    'alert-type' => 'success'
                ];
            }

            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);

            return response()->json([
                'response' => $notification['status'],
                'message'  => $notification['message']
            ]);

        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }
}
