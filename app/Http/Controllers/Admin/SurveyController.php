<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Plan;
use App\Survey;

class SurveyController extends Controller
{
    protected $survey;
    protected $plan;

    public function __construct(Survey $survey, Plan $plan)
    {
        $this->survey = $survey;
        $this->plan = $plan;
    }

    public function index(Plan $plan)
    {
        $questions = $plan->survey->template->questions;
        $survey = [];
        foreach ($questions as $question) {
            $survey[$question->text] = Answer::get($plan->survey, $question);
        }
        //\AppHelper::varDump($survey);

        return view('admin.survey.index', compact('survey', 'plan'));
    }


    public function create(User $user)
    {
        $user = $this->user->find($user->id);
        $project = $this->project;
        $projects = $this->project->where('user_id', $user->id)->orderBy('identifier', 'asc')->get()->pluck('identifier','id')->prepend('Select a parent','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        return view('admin.project.new', compact('project','projects','user','data_sources'));
    }


    public function store(ProjectRequest $request)
    {
        $data = array_filter($request->all(), 'strlen');
        $user = $this->user->find($data['user_id']);
        $project = $this->project->create($data);
        $project->importFromDataSource();

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
        return redirect()->route('admin.user.projects.index', $user);
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
        $user = User::find($request->user_id);
        //\AppHelper::varDump($request);
        $project = $this->project->findOrFail($id);
        // $data = array_filter($request->all(), 'strlen');
        $data = $request->all();
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $project->update($data);
        return redirect()->route('admin.user.projects.index', $user);
    }


    public function destroy($id)
    {
        $project = $this->project->findOrFail($id);
        $project->delete();
        return redirect()->route('admin.user.projects.index', $project->user->id);
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