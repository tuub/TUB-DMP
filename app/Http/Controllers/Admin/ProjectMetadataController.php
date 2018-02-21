<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Redirect;
use App\ProjectMetadata;
use App\Http\Requests\Admin\CreateProjectMetadataRequest;
use App\Http\Requests\Admin\UpdateProjectMetadataRequest;
use App\Library\Sanitizer;
use App\Library\Notification;

class ProjectMetadataController extends Controller
{
    protected $project_metadata;

    public function __construct(ProjectMetadata $project_metadata)
    {
        $this->project_metadata = $project_metadata;
    }


    public function index()
    {

    }


    public function create()
    {

    }


    public function store(CreateProjectMetadataRequest $request)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* Validate input */

        /* The operation */
        $op = $this->project_metadata->create($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the project metadatum!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the project metadatum!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    public function show($id)
    {
        return $this->project_metadata->findOrFail($id);
    }


    public function edit($id)
    {
        $project = $this->project->findOrFail($id);
        $projects = $this->project->all()->pluck('identifier','id')->prepend('Select a parent','');
        $users = User::all()->pluck('name_with_email','id')->prepend('Select an owner','');
        $data_sources = DataSource::all()->pluck('name','id')->prepend('Select a data source','');
        return view('admin.project.edit', compact('project','projects','users','data_sources'));
    }


    public function update(UpdateProjectMetadataRequest $request, $id)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* The validation */

        /* Get object */
        $project_metadata = $this->project_metadata->findOrFail($id);

        /* The operation */
        $op = $project_metadata->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the project metadatum!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the project metadatum!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    public function destroy(Request $request, $id)
    {
        /* Get object */
        $project_metadata = $this->project_metadata->find($id);

        /* The operation */
        $op = $project_metadata->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the project metadata!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the project metadata!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dasboard');
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