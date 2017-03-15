<?php

namespace App\Http\Controllers;

use App\HtmlOutputFilter;
use App\Template;
use Request;
use App\Http\Requests\SurveyRequest;
use App\Survey;

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
 * Class SurveyController
 *
 * @package App\Http\Controllers
 */
class SurveyController extends Controller
{
    protected $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }


    public function show($id)
    {
        $survey = $this->survey->with('plan', 'template')->findOrFail($id);
        $plan = $survey->plan;
        $questions = $survey->template->questions;
        if( $survey ) {
            if (Request::ajax()) {
                return $questions->toJson();
            } else {
                return view('survey.show', compact('survey'));
            }
        }
        throw new NotFoundHttpException;
    }

    /*
    public function store(PlanRequest $request)
    {
        $data = array_filter($request->all(), 'strlen');
        $this->plan->create($data);
        //dd($this->plan);
        if ($request->ajax()) {
            return response()->json([
                'response' => 200,
                'msg' => 'DMP created!'
            ]);
        };
    }


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


    // TODO: render method?
    public function edit($id) {
        $survey = $this->survey->with('plan', 'template')->findOrFail($id);
        //$question_count = Template::with('questions')->withCount('questions')->get();
        //dd($question_count);
        return view('survey.edit', compact('survey'))->render();
    }


    public function update(SurveyRequest $request)
    {
        $survey = $this->survey->findOrFail($request->id);
        $data = array_filter($request->all(), 'strlen');
        dd($data);
        /*
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        */
        //$plan->update($data);
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