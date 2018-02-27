<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectLookupRequest;
use App\MetadataRegistry;
use App\ProjectMetadata;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Project;
use App\User;
use App\DataSource;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectApproved;
use App\Mail\ProjectRejected;
use App\Library\Sanitizer;
use App\Library\Notification;

class ProjectController extends Controller
{
    /**
     * @var Project
     */
    protected $project;
    /**
     * @var User
     */
    protected $user;


    /**
     * ProjectController constructor.
     *
     * @param Project $project
     * @param User    $user
     */
    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * @param User $user
     *
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        $user = $this->user->find($user->id);
        $project = new $this->project;
        $projects = $this->project->where('user_id', $user->id)->orderBy('identifier', 'asc')->get()->pluck('identifier','id')->prepend('Select a parent','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        $return_route = 'admin.user.projects.index';
        return view('admin.project.create', compact('project','projects','user','data_sources', 'return_route'));
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
        $project->importFromDataSource();

        /* FIXME: The activation */
        //$project->approve();

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
     *
     * @return mixed
     */
    public function show($id)
    {
        return $this->project->findOrFail($id);
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $project = $this->project->findOrFail($id);
        $user = $project->user;
        $projects = $this->project->orderBy('identifier', 'asc')->get()->pluck('identifier','id')->prepend('Select a parent','');
        $users = User::orderBy('email', 'asc')->get()->pluck('email','id')->prepend('Select an owner','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        $return_route = 'admin.user.projects.index';

        return view('admin.project.edit', compact('project','projects','user','users','data_sources', 'return_route'));
    }


    /**
     * @param UpdateProjectRequest $request
     * @param                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
        $data_sources = DataSource::get()->pluck('identifier','id')->prepend('Select a datasource','');
        return view('admin.project.lookup', compact('data_sources'));
    }


    /**
     * @param ProjectLookupRequest $request
     *
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request) {
        $project = $this->project->findOrFail($request->id);

        /* The operation */
        $op = $project->approve();

        /* Notification & Mail */
        if ($op) {
            $notification = new Notification(200, 'Successfully approved the project request!', 'success');
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request) {
        $project = $this->project->findOrFail($request->id);

        /* The operation */
        $op = $project->destroy($project->id); // FIXME: destroy param!?

        /* Notification & Mail */
        if ($op) {
            $notification = new Notification(200, 'Successfully rejected the project request!', 'success');
            Mail::to($project->user->email)->send(new ProjectRejected($project));
        } else {
            $notification = new Notification(500, 'Error while rejecting the project request!', 'error');
        }

        // FIXME: not working flash because of redirect
        // FIXME: another bug, project request doesn't show error when entering already existing project id

        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     *
     */
    public function random_ivmc() {
        $connection = odbc_connect( "IVMC_MSSQL_2", env('ODBC_USERNAME'), env('ODBC_PASSWORD') );
	
	$query = 'SELECT TOP 15 Projekt_Nr FROM t_821300_IVMC_DMP_Projekt ORDER BY NEWID()'; // SQL Server
	// $query = 'SELECT "Projekt_Nr" FROM "t_821300_IVMC_DMP_Projekt" ORDER BY RANDOM() LIMIT 15'; //PostgreSQL
        
	$result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            echo $row['Projekt_Nr'];
            echo '<hr/>';
        }
    }

    /* FIXME: REMOVE AFTER TESTING */
    /**
     * @param $project_number
     */
    public function raw_ivmc( $project_number )
    {
        $connection = odbc_connect( "IVMC_MSSQL_2", "WIN\svc-ub-dmp", "vByZ80az" );

        $query = "select * from t_821300_IVMC_DMP_Projekt where Projekt_Nr = '" . $project_number . "'";
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            $fields[] = $row;
        }
        echo '<h1>t_821300_IVMC_DMP_Projekt</h1>';
        if ( isset( $fields ) ) {
            echo '<pre>';
            var_dump( $fields );
            echo '</pre>';
            unset( $fields );
        }

        $query = "select * from t_821310_IVMC_DMP_Projektpartner_extern where Projekt_Nr = '" . $project_number . "'";
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            $fields[] = $row;
        }
        echo '<h1>t_821310_IVMC_DMP_Projektpartner_extern</h1>';
        if ( isset( $fields ) ) {
            echo '<pre>';
            var_dump( $fields );
            echo '</pre>';
            unset( $fields );
        }

        $query = "select * from t_821311_IVMC_DMP_Projektpartner_intern where Projekt_Nr = '" . $project_number . "'";
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            $fields[] = $row;
        }
        echo '<h1>t_821311_IVMC_DMP_Projektpartner_intern</h1>';
        if ( isset( $fields ) ) {
            echo '<pre>';
            var_dump( $fields );
            echo '</pre>';
            unset( $fields );
        }

        $query = "select * from t_821320_IVMC_DMP_Weitere_Projektleiter where Projekt_Nr = '" . $project_number . "'";
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            $fields[] = $row;
        }
        echo '<h1>t_821320_IVMC_DMP_Weitere_Projektleiter</h1>';
        if ( isset( $fields ) ) {
            echo '<pre>';
            var_dump( $fields );
            echo '</pre>';
            unset( $fields );
        }

        $query = "select * from t_821396_IVMC_DMP_Schlagworte where Projekt_Nr = '" . $project_number . "'";
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            $fields[] = $row;
        }
        echo '<h1>t_821396_IVMC_DMP_Schlagworte</h1>';
        if ( isset( $fields ) ) {
            echo '<pre>';
            var_dump( $fields );
            echo '</pre>';
            unset( $fields );
        }


    }

}
