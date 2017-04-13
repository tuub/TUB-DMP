<?php

namespace App\Http\Controllers;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\EmailPlanRequest;
use App\Http\Requests\VersionPlanRequest;
use App\Events\PlanUpdated;
use App\Plan;
use App\Template;

use Illuminate\Support\Facades\App;
use App\Survey;
use App\Events\PlanCreated;
use App\Http\Requests\VersionRequest;

use App\HtmlOutputFilter;
use Event;
use Request;
use Redirect;
use Gate;

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
        if ($request->ajax())
        {
            return response()->json([
                'response'  => 200,
                'msg'       => 'DMP with Survey created!'
            ]);
        };
    }


    public function show($id)
    {
        $plan = $this->plan->findOrFail($id);

        if (Request::ajax())
        {
            if (!$plan)
            {
                return response()->json([
                    'response' => 404,
                    'message' => 'Plan was not found.'
                ]);
            }
            return $plan->toJson();

        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }


    public function update(PlanRequest $request)
    {
        $plan = $this->plan->findOrFail($request->id);

        /*
        if (Gate::denies('update', [auth()->user(), $plan])) {
            return response()->json([
                'response' => 403,
                'msg' => 'Forbidden!'
            ]);
        }
        */

        if ($request->ajax())
        {
            $data = array_filter($request->all(), 'strlen');

            if($plan->update($data))
            {
                $response = 200;
                $message = 'Plan was successfully updated!';
                Event::fire(new PlanUpdated($plan));
            }

            /* Response */
            return response()->json([
                'response' => $response,
                'message' => $message,
            ]);

        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }


    /**
     * Sets the final flag.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleState($id)
    {
        $plan = $this->plan->findOrFail($id);

        if ($plan)
        {
            if ($plan->isFinal())
            {
                $plan->setFinalFlag(false);
                // TODO: Replace?
                //Notifier::success('Plan unfinalized successfully!')->flash()->create();
            } else {
                $plan->setFinalFlag(true);
                // TODO: Replace?
                //Notifier::success('Plan finalized successfully!')->flash()->create();
            }
        } else {
            abort(404, 'Plan was not found.');
            // TODO: Replace?
            //Notifier::error( 'Error while finalizing plan!' )->flash()->create();
        }

        return Redirect::route( 'dashboard' );
    }


    public function version(VersionPlanRequest $request)
    {
        $data = $request->except(['_token']);

        if ($this->plan->createNextVersion($data))
        {
            $response = 200;
            $message = 'New version created!';
            //Notifier::success( $msg )->flash()->create();
        } else {
            $response = 500;
            $message = 'Versioning failed!';
            //Notifier::error( $msg )->flash()->create();
        }

        /* Render the response */
        if ($request->ajax())
        {
            return response()->json([
                'response' => $response,
                'message' => $message
            ]);
        } else {
            abort(403, 'Direct access is not allowed.');
        };
    }


    public function email(EmailPlanRequest $request)
    {
        $data = $request->except(['_token']);

        if ($this->plan->emailToRecipient($data))
        {
            $response = 200;
            $msg = 'Mail was sent.';
        } else {
            $response = 500;
            $msg = 'Mail was not sent.';
        }

        /* Response */
        if ($request->ajax())
        {
            return response()->json([
                'response' => $response,
                'msg' => $msg,
            ]);
        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }


    // TODO: Snappy & WKHTML2PDF
    public function export($id)
    {
        $plan = $this->plan->findOrFail($id);
        return $plan->exportPlan();

        /*
        $project = $plan->project;
        $survey = $plan->survey;

        $header_html = (string) view('pdf.header');
        $footer = $plan->project->identifier . ' - ' . $plan->title . ', [page]';

        $pdf = PDF::loadView('pdf.dmp', compact('plan', 'project', 'survey'));
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('margin-top', '10mm');
        $pdf->setOption('margin-bottom', '20mm');
        $pdf->setOption('margin-left', '20mm');
        $pdf->setOption('margin-right', '20mm');
        $pdf->setOption('header-html', $header_html);
        $pdf->setOption('footer-font-size', '8');
        $pdf->setOption('footer-right',$footer);
        //return $pdf->stream();
        //return view('pdf.dmp', compact('plan', 'project', 'survey'));

        */

        /*

        if($this->plan->exportPlan($id, $format, $download)) {
            //$msg = 'Exported successfully!';
            //Notifier::success( $msg )->flash()->create();
        } else {
            //$msg = 'Export failed!';
            //Notifier::error( $msg )->flash()->create();
        }
        return Redirect::route('dashboard');
        */
    }


    // TODO!
    public function destroy($id)
    {

    }

    // TODO!
    public function copy($id)
    {

    }
}