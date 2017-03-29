<?php

namespace App\Http\Controllers;

use App\HtmlOutputFilter;
use App\Survey;
use Request;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\VersionRequest;

use App\Http\Requests\EmailPlanRequest;

use App\Http\Requests\VersionPlanRequest;

use Event;
use App\Events\PlanCreated;
use App\Events\PlanUpdated;

use App\IvmcMapping;
use App\Plan;
use App\User;
use App\Question;
use App\Answer;
use App\Template;

//use PhpSpec\Process\Shutdown\UpdateConsoleAction;
use Jenssegers\Optimus\Optimus;
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

    public function __construct(Template $template, Plan $plan)
    {
        $this->template = $template;
        $this->plan = $plan;
    }


    public function store(PlanRequest $request)
    {
        /* Filter out all empty inputs */
        $data = array_filter($request->all(), 'strlen');

        /* Create Plan with corresponding Survey */
        $this->plan->createWithSurvey($data['title'], $data['project_id'], $data['version'], $data['template_id']);

        /* Create a response in JSON */
        if ($request->ajax()) {
            return response()->json([
                'response'  => 200,
                'msg'       => 'DMP with Survey created!'
            ]);
        };
    }


    public function show($id) {
        $plan = $this->plan->findOrFail($id);
        if( $plan ) {
            if (Request::ajax()) {
                return $plan->toJson();
            } else {
                return view('plan.show', compact('plan'));
            }
        }
        //throw new NotFoundHttpException;
    }


    public function update(PlanRequest $request)
    {
        $plan = $this->plan->findOrFail($request->id);
        $data = array_filter($request->all(), 'strlen');

        $plan->update($data);
        Event::fire(new PlanUpdated($plan));

        /* Response */
        if ($request->ajax()) {
            return response()->json([
                'response' => 200,
                'msg' => 'DMP updated!'
            ]);
        };
    }


    public function toggleState($id)
    {
        $plan = $this->plan->findOrFail($id);

        if( $plan ) {
            if ( $plan->isFinal() ) {
                $plan->setFinalFlag(false);
                Notifier::success('Plan unfinalized successfully!')->flash()->create();
            } else {
                $plan->setFinalFlag(true);
                Notifier::success('Plan finalized successfully!')->flash()->create();
            }
        } else {
            Notifier::error( 'Error while finalizing plan!' )->flash()->create();
        }

        return Redirect::route( 'dashboard' );
    }


    public function version(VersionPlanRequest $request)
    {
        $data = $request->except(['_token']);
        if ($this->plan->createNextVersion($data)) {
            $response = 200;
            $msg = 'New version created!';
            //Notifier::success( $msg )->flash()->create();
        } else {
            $response = 500;
            $msg = 'Versioning failed!';
            //Notifier::error( $msg )->flash()->create();
        }

        /* Response */
        if ($request->ajax()) {
            return response()->json([
                'response' => $response,
                'msg' => $msg
            ]);
        };
    }





    public function email(EmailPlanRequest $request)
    {
        $data = $request->except(['_token']);
        if ($this->plan->emailToRecipient($data)) {
            $response = 200;
            $msg = 'Mail sent!';
        } else {
            $response = 500;
            $msg = 'Mail not sent!';
        }

        /* Response */
        if ($request->ajax()) {
            return response()->json([
                'response' => $response,
                'msg' => $msg,
            ]);
        };
    }






    public function export($id, $format = null, $download = true)
    {
        if($this->plan->exportPlan($id, $format, $download)) {
            //$msg = 'Exported successfully!';
            //Notifier::success( $msg )->flash()->create();
        } else {
            //$msg = 'Export failed!';
            //Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route('dashboard');
    }





    public function destroy($id) {

    }
}