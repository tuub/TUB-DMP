<?php

namespace App\Http\Controllers;

use App\HtmlOutputFilter;
use App\Http\Requests\Request;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\EmailPlanRequest;
use App\Http\Requests\VersionPlanRequest;
use App\Http\Requests\UpdatePlanRequest;

use App\IvmcMapping;
use App\Plan;
use App\User;
use App\Question;
use App\Answer;
use App\Template;

//use PhpSpec\Process\Shutdown\UpdateConsoleAction;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laracasts\Flash\Flash;

use Auth;
//use Exporters;
use Redirect;
use Log;
use Mail;
use Notifier;
use View;

/**
 * Class PlanController
 *
 * @package App\Http\Controllers
 */
class PlanController extends Controller
{
    protected $plan;
    protected $template;

    public function __construct( Plan $plan, Template $template )
    {
        $this->plan = $plan;
        $this->template = $template;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $internal_templates = $this->template->where( 'institution_id', 1 )->where('is_active', 1)->lists( 'name', 'id' )->toArray();
        $external_templates = $this->template->where( 'institution_id', 1 )->where('is_active', 1)->lists( 'name', 'id' )->toArray();
        //$template_selector = [ 'TU Berlin' => $internal_templates ] + [ 'Other Organisations' => $external_templates ];
        $template_selector = $internal_templates;
        $user_selector = User::active()->lists('real_name','id')->toArray();
        $plans = $this->plan->getPlans();
        return view('dashboard', compact('plans', 'template_selector', 'user_selector'));
    }


    /**
     * @param $project_number
     * @param $version
     *
     * @return View
     * @throws NotFoundHttpException
     */
    public function show( $project_number, $version ) {
        $plan = $this->plan->getByCredentials($project_number, $version, Auth::user()->id);
        if( $plan ) {
            return view('plan.show', compact('plan'));
        }
        throw new NotFoundHttpException;
    }

    /**
     * @param $project_number
     * @param $version
     *
     * @return View
     * @throws NotFoundHttpException
     */
    public function edit( $project_number, $version ) {
        $plan = $this->plan->getByCredentials($project_number, $version, Auth::user()->id);
        if( $plan ) {
            return view('plan.edit', compact('plan'));
        }
        throw new NotFoundHttpException;
    }


    /**
     * @param UpdatePlanRequest $request
     *
     * @return Redirect
     */
    public function update( UpdatePlanRequest $request )
    {
        if( $this->plan->updatePlan( $request ) ) {
            $msg = 'Save';
            if ( $request->ajax() ) {
                return response()->json(['message' => $msg]);
            }
            Notifier::success( $msg )->flash()->create();
        } else {
            $msg = 'Not saved!';
            if ( $request->ajax() ) {
                return response()->json(['message' => $msg]);
            }
            Notifier::error( $msg )->flash()->create();
        }
        return Redirect::back();
    }


    /**
     * @param $project_number
     * @param $version
     *
     * @return mixed
     */
    public function toggle( $project_number, $version )
    {
        $plan = $this->plan->getByCredentials($project_number, $version, Auth::user()->id);
        if( $plan ) {
            if ( $plan->isFinal() ) {
                $plan->setFinalFlag( false );
                Notifier::success( 'Plan unfinalized successfully!' )->flash()->create();
            } else {
                $plan->setFinalFlag( true );
                Notifier::success( 'Plan finalized successfully!' )->flash()->create();
            }
        } else {
            Notifier::error( 'Error while finalizing plan!' )->flash()->create();
        }
        return Redirect::route( 'dashboard' );
    }

    /**
     * @param EmailPlanRequest $request
     *
     * @return Redirect
     */
    public function email( EmailPlanRequest $request )
    {
        if( $this->plan->emailPlan($request) ) {
            $msg = 'Emailed successfully!';
            Notifier::success( $msg )->flash()->create();
        } else {
            $msg = 'Emailing failed!';
            Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route( 'dashboard' );
    }


    /**
     * @param $project_number
     * @param $version
     * @param $format
     * @param $download
     *
     * @return Redirect
     */
    public function export( $project_number, $version, $format = null, $download = true )
    {
        if( $this->plan->exportPlan($project_number, $version, $format, $download) ) {
            //$msg = 'Exported successfully!';
            //Notifier::success( $msg )->flash()->create();
        } else {
            //$msg = 'Export failed!';
            //Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route( 'dashboard' );
    }


    /**
     * @param VersionPlanRequest $request
     *
     * @return Redirect
     */
    public function version( VersionPlanRequest $request )
    {
        if( $this->plan->createVersion( $request ) ) {
            $msg = 'New version added!';
            Notifier::success( $msg )->flash()->create();
        } else {
            $msg = 'Versioning failed!';
            Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route('dashboard');
    }


    /**
     * @param CreatePlanRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create( CreatePlanRequest $request )
    {
        if( $this->plan->createPlan( $request ) ) {
            $msg = 'Plan created successfully!';
            Notifier::success( $msg )->flash()->create();
        } else {
            $msg = 'There is already a plan with this project number / version!';
            Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route( 'dashboard' );
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        //
    }
}