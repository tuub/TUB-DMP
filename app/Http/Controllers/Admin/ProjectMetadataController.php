<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ProjectMetadataController extends Controller
{
    protected $project_metadata;

    public function __construct(ProjectMetadata $project_metadata)
    {
        $this->project_metadata = $project_metadata;
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
        $projects = $this->project->all()->pluck('identifier','id')->prepend('Select a parent','');
        $users = User::all()->pluck('real_name','id')->prepend('Select an owner','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        return view('admin.project.new', compact('project','projects','users','data_sources'));
    }


    public function store(ProjectRequest $request)
    {
        $data = array_filter($request->all(), 'strlen');
        $this->project->create($data);
        return Redirect::route('admin.project.index');
    }


    public function show($id)
    {
        return $this->project->findOrFail($id);
    }


    public function edit($id)
    {
        $project = $this->project->findOrFail($id);
        $projects = $this->project->all()->pluck('identifier','id')->prepend('Select a parent','');
        $users = User::all()->pluck('name_with_email','id')->prepend('Select an owner','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        return view('admin.project.edit', compact('project','projects','users','data_sources'));
    }


    public function update(ProjectRequest $request, $id)
    {
        $project = $this->project->findOrFail($id);
        // TODO: field just does not get updated
        // $data = array_filter($request->all(), 'strlen');
        $data = $request->all();
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $project->update($data);
        return Redirect::route('admin.project.index');
    }


    public function destroy($id)
    {
        $project = $this->project->findOrFail($id);
        $project->delete();
        return Redirect::route('admin.project.index');
    }


    /* TODO: REMOVE AFTER TESTING */
    public function random_ivmc() {
        $connection = odbc_connect( "IVMC_MSSQL", "WIN\svc-ub-dmp", "vByZ80az" );
        $query = "SELECT TOP 15 Projekt_Nr FROM t_821300_IVMC_DMP_Projekt ORDER BY NEWID()";
        //$query = "SELECT TOP 15 * FROM t_821311_IVMC_DMP_Projektpartner_intern ORDER BY NEWID()";
        //$query = "SELECT TOP 15 * FROM t_821320_IVMC_DMP_Weitere_Projektleiter ORDER BY NEWID()";
        //$query = "SELECT TOP 15 * FROM t_821396_IVMC_DMP_Schlagworte ORDER BY NEWID()";
        $result = odbc_exec( $connection, $query );
        while ( $row = odbc_fetch_array( $result ) ) {
            echo $row['Projekt_Nr'];
            echo '<hr/>';
        }
    }

    /* TODO: REMOVE AFTER TESTING */
    public function test_ivmc( $project_number ) {

        $connection_string = 'DRIVER={ODBC Driver 11 for SQL Server};SERVER=130.149.180.15:1435;DATABASE=IVMC_SQL';
        $user = 'WIN\svc-ub-dmp';
        $pass = 'vByZ80az';
        $connection = odbc_connect( $connection_string, $user, $pass );
        dd( $connection );
        /*
        $connection = odbc_connect( "IVMC_MSSQL", "WIN\svc-ub-dmp", "vByZ80az" );
        $plan_id = Plan::getPlanID( $project_number , 1 );
        $plan = Plan::getPlan( $plan_id );
        $result = IvmcMapping::setFields( $plan, 't_821320_IVMC_DMP_Weitere_Projektleiter', $connection );
        */
    }

    /* TODO: REMOVE AFTER TESTING */
    public function raw_ivmc( $project_number, $version )
    {
        $connection = odbc_connect( "IVMC_MSSQL", "WIN\svc-ub-dmp", "vByZ80az" );

        $tables_result = IvmcMapping::distinct()->select( 'source' )->get( 'source' )->toArray();
        foreach ( $tables_result as $value ) {
            $tables[] = $value['source'];
        }
        foreach ( $tables as $table ) {
            echo '<h2>' . $table . '</h2>';

            $query = "select * from " . $table . " where Projekt_Nr = '" . $project_number . "'";
            $result = odbc_exec( $connection, $query );
            while ( $row = odbc_fetch_array( $result ) ) {
                $fields[] = $row;
            }

            if ( isset( $fields ) ) {
                echo '<pre>';
                var_dump( $fields );
                echo '</pre>';
                unset( $fields );
            }
        }
    }

}