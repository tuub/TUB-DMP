<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProjectLookupRequest;
use App\Http\Requests\Admin\CreateProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Project;
use App\User;
use App\DataSource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectApproved;
use App\Mail\ProjectRejected;
use App\Library\Sanitizer;
use App\Library\Notification;
use Illuminate\View\View;


/**
 * Class ProjectController
 *
 * @package App\Http\Controllers\Admin
 */
class ProjectController extends Controller
{
    protected $project;
    protected $user;


    /**
     * ProjectController constructor.
     *
     * @param Project $project
     * @param User $user
     */
    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $user = $this->user->find($user->id);
        // Get only parent projects so we can include the child projects via view
        $projects = $this->project->roots()->withCount('plans')->where('user_id', $user->id)->get()->toHierarchy();
        return view('admin.project.index', compact('user', 'projects'));
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        $view_name = 'admin.project.create';
        $return_route = 'admin.user.projects.index';

        $user = $this->user->find($user->id);
        $project = new $this->project;

        if (env('PROJECT_ALLOW_DATASOURCE_IMPORT')) {
            $data_sources = DataSource::get()->pluck('name','id')->prepend('Select a data source','');
        } else {
            $data_sources = collect([null => 'Disabled by configuration']);
        }

        return view($view_name, compact('project','user','data_sources', 'return_route'));
    }


    /**
     * @param CreateProjectRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProjectRequest $request)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* The operation */
        $user = $this->user->find($data['user_id']);
        $project = $op = $this->project->create($data);

        /* The metadata import */
        if (env('PROJECT_ALLOW_DATASOURCE_IMPORT')) {
            $project->importFromDataSource();
        }

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the project!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the project!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $user);
    }


    /**
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        return $this->project->findOrFail($id);
    }


    /**
     * @param $id
     * @return View
     * @throws ModelNotFoundException
     */
    public function edit($id)
    {
        $view_name = 'admin.project.edit';
        $return_route = 'admin.user.projects.index';

        $project = $this->project->findOrFail($id);

        if (env('PROJECT_ALLOW_DATASOURCE_IMPORT')) {
            $data_sources = DataSource::get()->pluck('name','id')->prepend('Select a data source','');
        } else {
            $data_sources = collect([null => 'Disabled by configuration']);
        }

        return view($view_name, compact('project','data_sources', 'return_route'));
    }


    /**
     * @param UpdateProjectRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ModelNotFoundException
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get object */
        $project = $this->project->findOrFail($id);

        /* The operation */
        $op = $project->update($data);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the project!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the project!', 'error');
        }

        $notification->toSession($request);

        return redirect()->route($return_route, $project->user->id);
    }


    /**
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        /* Get object */
        $project = $this->project->find($id);

        /* The operation */
        $op = $project->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the project!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the project!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.user.projects.index', $project->user->id);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLookup() {
        if (env('PROJECT_ALLOW_DATASOURCE_IMPORT')) {
            $data_sources = DataSource::get()->pluck('name','id')->prepend('Select a data source','');
        } else {
            $data_sources = collect([null => 'Disabled by configuration']);
        }
        return view('admin.project.lookup', compact('data_sources'));
    }


    /**
     * @param ProjectLookupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLookup(ProjectLookupRequest $request)
    {
        /* The operation */
        $op = $data = Project::lookupDataSource($request->identifier);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully looked up the project!', 'success');
        } else {
            $notification = new Notification(500, 'Error while looking up the project!', 'error');
        }
        $notification->toSession($request);
        return json_encode($data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ModelNotFoundException
     */
    public function approve(Request $request) {
        $project = $this->project->find($request->id);

        /* The operation */
        $op = $project->approve();
        $import = $project->importFromDataSource();

        /* Notification & Mail */
        if ($op) {
            $notification = new Notification(200, 'Successfully approved the project request!', 'success');
            if ($import) {
                $notification->message .= ' Data Imported!';
            }
            Mail::to($project->user->email)->send(new ProjectApproved($project));
        } else {
            $notification = new Notification(500, 'Error while approving the project request!', 'error');
            Mail::to($project->user->email)->send(new ProjectRejected($project));
        }

        // FIXME: not working flash because of redirect
        // FIXME: another bug, project request doesn't show error when entering already existing project id

        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request) {
        $project = $this->project->find($request->id);

        /* The operation */
        $op = $project->destroy($project->id); // FIXME: destroy param!?

        /* Notification & Mail */
        if ($op) {
            Mail::to($project->user->email)->send(new ProjectRejected($project));
            $notification = new Notification(200, 'Successfully rejected the project request!', 'success');
        } else {
            $notification = new Notification(500, 'Error while rejecting the project request!', 'error');
        }

        // FIXME: not working flash because of redirect
        // FIXME: another bug, project request doesn't show error when entering already existing project id

        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     * @return string
     */
    public function random_identifier() {

        $result = '';

        /* @todo: Refactor to method since used in several places */
        if (env('DEMO_MODE')) {
            $connection = env('PROJECT_DEMO_CONNECTION');
        } else {
            $connection = env('ODBC_DRIVER');
        }

        /* @var $identifiers \Illuminate\Support\Collection[] */
        $identifiers = DB::connection($connection)
            ->table('t_821300_IVMC_DMP_Projekt')
            ->select('Projekt_Nr')
            ->limit(15)
            ->inRandomOrder()
            ->get();

        foreach($identifiers as $identifier) {
            $result .= $identifier->Projekt_Nr . PHP_EOL;
        }

        return $result;
    }
}
