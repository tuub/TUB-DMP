<?php

namespace App\Http\Controllers;

use App\HtmlOutputFilter;
use App\Survey;
use Request;
use App\Http\Requests\PlanRequest;
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

    // TODO: Check! Everything necessary? GetPlans necessary?
    public function index()
    {
        $internal_templates = $this->template->where( 'institution_id', 1 )->where('is_active', 1)->pluck( 'name', 'id' );
        $external_templates = $this->template->where( 'institution_id', 1 )->where('is_active', 1)->pluck( 'name', 'id' );
        $template_selector = [ 'TU Berlin' => $internal_templates ] + [ 'Other Organisations' => $external_templates ];
        //$template_selector = $internal_templates;
        $user_selector = User::active()->pluck('real_name','id');
        $plans = $this->plan->getPlans();
        return view('dashboard', compact('plans', 'template_selector', 'user_selector'));
    }

    public function store(PlanRequest $request)
    {
        /* Filter out all empty inputs */
        $data = array_filter($request->all(), 'strlen');

        /* Create a new plan instance */
        $plan = new $this->plan;
        $plan = $plan->create([
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'version' => $data['version'],
        ]);

        /* Create a new survey instance and attach plan to it */
        $survey = new Survey;
        $survey->plan()->associate($plan);
        $survey->template_id = $data['template_id'];
        $survey->save();

        /* Fire plan create event */
        Event::fire(new PlanCreated($plan));

        /* Create a response in JSON */
        if ($request->ajax()) {
            return response()->json([
                'response' => 200,
                'msg' => 'DMP with Survey created!'
            ]);
        };
    }

    /*
    public function store(PlanRequest $request)
    {
        if($this->plan->createPlan($request)) {
            $msg = 'Plan created successfully!';
            Notifier::success( $msg )->flash()->create();
        } else {
            $msg = 'There is already a plan with this project number / version!';
            Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route( 'dashboard' );
    }
    */


    public function show($id) {
        $plan = $this->plan->findOrFail($id);
        if( $plan ) {
            if (Request::ajax()) {
                return $plan->toJson();
            } else {
                return view('plan.show', compact('plan'));
            }
        }
        throw new NotFoundHttpException;
    }


    public function edit($id) {
        $plan = $this->plan->findOrFail($id);
        $templates = collect([]);
        return view('plan.edit', compact('plan','templates'))->render();
    }


    public function update(PlanRequest $request)
    {
        $plan = $this->plan->findOrFail($request->id);
        $data = array_filter($request->all(), 'strlen');
        /*
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        */

        /* Fire plan create event */
        Event::fire(new PlanUpdated($plan));

        $plan->update($data);
        if ($request->ajax()) {
            return response()->json([
                'response' => 200,
                'msg' => 'DMP updated!'
            ]);
        };
            /*
            $input = Input::all();//Get all the old input.
            $input['autoOpenModal'] = 'true';//Add the auto open indicator flag as an input.
            return Redirect::back()
                ->withErrors($this->messageBag)
                ->withInput($input);//Passing the old input and the flag.
            */
            //return response()->json(['message' => 'OK']);

        //return Redirect::route('dashboard');
        /*
        if($this->plan->updatePlan($request)) {
            $msg = 'Save';
            if ($request->ajax()) {
                return response()->json(['message' => $msg]);
            }
            Notifier::success($msg)->flash()->create();
        } else {
            $msg = 'Not saved!';
            if ($request->ajax()) {
                return response()->json(['message' => $msg]);
            }
            Notifier::error($msg)->flash()->create();
        }
        return Redirect::back();
        */
        //return $request->ajax();
    }


    public function toggle($id)
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


    public function email(EmailPlanRequest $request)
    {
        if($this->plan->emailPlan($request)) {
            $msg = 'Emailed successfully!';
            Notifier::success($msg)->flash()->create();
        } else {
            $msg = 'Emailing failed!';
            Notifier::error($msg)->flash()->create();
        }
        return Redirect::route('dashboard');
    }


    /**
     * @param $project_number
     * @param $version
     * @param $format
     * @param $download
     *
     * @return Redirect
     */
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


    public function version(VersionPlanRequest $request)
    {
        if($this->plan->createVersion($request)) {
            $msg = 'New version added!';
            Notifier::success( $msg )->flash()->create();
        } else {
            $msg = 'Versioning failed!';
            Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route('dashboard');
    }


    public function destroy( $id ) {
        //
    }
}