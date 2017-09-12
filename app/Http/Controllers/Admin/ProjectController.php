<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectLookupRequest;
use App\MetadataRegistry;
use App\ProjectMetadata;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Admin\ProjectRequest;
use App\Project;
use App\User;
use App\DataSource;
use DB;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function index()
    {
        // Get only parent projects so we can include the child projects via view
        $projects = $this->project->get()->toHierarchy();
        return view('admin.project.index', compact('projects'));
    }


    public function create()
    {
        $project = $this->project;
        $projects = $this->project->orderBy('identifier', 'asc')->get()->pluck('identifier','id')->prepend('Select a parent','');
        $users = User::orderBy('email', 'asc')->get()->pluck('email','id')->prepend('Select an owner','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        return view('admin.project.new', compact('project','projects','users','data_sources'));
    }


    public function store(ProjectRequest $request)
    {
        $data = array_filter($request->all(), 'strlen');
        $project = $this->project->create($data);

        if ($project) {
            Mail::send( [ 'text' => 'emails.project-created' ], [ 'project' => $project ],
                function ( $message ) use ( $project ) {
                    $subject = 'Your TUB-DMP Project has been created';
                    $message->from( env('ADMIN_MAIL_ADDRESS', 'server@localhost'), env('ADMIN_MAIL_NAME', 'TUB-DMP Admin') );
                    $message->to( $project->user->email )->subject( $subject );
                    $message->replyTo( env('ADMIN_MAIL_ADDRESS', 'server@localhost'), env('ADMIN_MAIL_NAME', 'TUB-DMP Admin') );
                }
            );

            if (Mail::failures()) {
                $notification = [
                    'status' => 500,
                    'message' => 'There was a problem when sending project notification to ' . $project->user->email . '!',
                    'alert-type' => 'error'
                ];
            } else {
                $notification = [
                    'status' => 200,
                    'message' => 'Project notification was sent to ' . $project->user->email . '!',
                    'alert-type' => 'success'
                ];
            }

            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);
        };
        return redirect()->route('admin.project.index');
    }


    public function show($id)
    {
        return $this->project->findOrFail($id);
    }


    public function edit($id)
    {
        $project = $this->project->findOrFail($id);
        $projects = $this->project->orderBy('identifier', 'asc')->get()->pluck('identifier','id')->prepend('Select a parent','');
        $users = User::orderBy('email', 'asc')->get()->pluck('email','id')->prepend('Select an owner','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        return view('admin.project.edit', compact('project','projects','users','data_sources'));
    }


    public function update(ProjectRequest $request, $id)
    {
        $project = $this->project->findOrFail($id);
        // $data = array_filter($request->all(), 'strlen');
        $data = $request->all();
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $project->update($data);
        return redirect()->route('admin.project.index');
    }


    public function destroy($id)
    {
        $project = $this->project->findOrFail($id);
        $project->delete();
        return redirect()->route('admin.project.index');
    }


    public function getLookup() {
        $data_sources = DataSource::get()->pluck('identifier','id')->prepend('Select a datasource','');
        return view('admin.project.lookup', compact('data_sources'));
    }


    public function postLookup(ProjectLookupRequest $request)
    {
        $data = Project::lookupDataSource($request->identifier);

        if ($data) {
            $notification = [
                'status' => 200,
                'data' => $data,
                'message' => 'Project Lookup successfull!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Project Lookup not successfull!',
                'alert-type' => 'error'
            ];
        }

        /* Response */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        return response()->json([
            'status' => $notification['status'],
            'data' => $notification['data'],
            'message'  => $notification['message']
        ]);

    }


    public function random_ivmc() {
        $connection = odbc_connect( "PSQL_ODBC", env('ODBC_USERNAME'), env('ODBC_PASSWORD') );
        if (env('ODBC_DRIVER') == 'sqlsrv') {
            $query = 'SELECT TOP 15 Projekt_Nr FROM t_821300_IVMC_DMP_Projekt ORDER BY NEWID()';
        }
        if (env('ODBC_DRIVER') == 'pgsql') {
            $query = 'SELECT "Projekt_Nr" FROM "t_821300_IVMC_DMP_Projekt" ORDER BY RANDOM() LIMIT 15';
        }
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            echo $row['Projekt_Nr'];
            echo '<hr/>';
        }
    }

    /* FIXME: REMOVE AFTER TESTING */
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