<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Http\Requests\EmailPlanRequest;
use App\Http\Requests\VersionPlanRequest;
use App\Events\PlanUpdated;
use App\Plan;
use App\Template;

use Event;

//use App\HtmlOutputFilter;
use Request;
//use Illuminate\Support\Facades\Gate;


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


    /**
     * Stores a new plan instance with accompanying survey instance via
     * model method createWithSurvey()
     *
     * @param PlanRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PlanRequest $request)
    {
        /* Filter out all empty inputs */
        $data = array_filter($request->all(), 'strlen');

        /* Create Plan with corresponding Survey */
        if ($this->plan->createWithSurvey($data['title'], $data['project_id'], $data['version'], $data['template_id'])) {
            $notification = [
                'status'     => 200,
                'message'    => 'Plan was successfully created!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status'     => 500,
                'message'    => 'Plan was not created!',
                'alert-type' => 'error'
            ];
        }

        /* Create Flash session with return values for notification */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        /* Create the response in JSON */
        if ($request->ajax()) {
            return response()->json([
                'response' => $notification['status'],
                'message'  => $notification['message']
            ]);
        };
    }


    public function show($id)
    {
        $plan = $this->plan->findOrFail($id);
        $this->authorize('show', $plan);

        if (Request::ajax()) {
            if (!$plan) {
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


    /**
     * Updates the plan instance.
     *
     * @param PlanRequest $request
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function update(PlanRequest $request)
    {
        $plan = $this->plan->findOrFail($request->id);

        if ($request->ajax()) {
            $data = array_filter($request->all(), 'strlen');

            if ($plan->update($data)) {
                $notification = [
                    'status'     => 200,
                    'message'    => 'Plan was successfully updated!',
                    'alert-type' => 'success'
                ];
                Event::fire(new PlanUpdated($plan));
            } else {
                $notification = [
                    'status'     => 500,
                    'message'    => 'Plan was not updated!',
                    'alert-type' => 'error'
                ];
            }

            /* Response */
            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);

            return response()->json([
                'response' => $notification['status'],
                'message'  => $notification['message']
            ]);

        } else {
            abort(403, 'Direct access is not allowed.');
        }

        return false;
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

        if ($plan) {
            if ($plan->isFinal()) {
                $plan->setFinalFlag(false);
                $notification = [
                    'status' => 200,
                    'message' => 'Plan unfinalized successfully!',
                    'alert-type' => 'success'
                ];
            } else {
                $plan->setFinalFlag(true);
                $notification = [
                    'status' => 200,
                    'message' => 'Plan finalized successfully!',
                    'alert-type' => 'success'
                ];
            }
        } else {
            abort(404, 'Plan was not found.');
            $notification = [
                'status' => 404,
                'message' => 'Error while finalizing plan!',
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('dashboard')->with($notification);
    }


    public function version(VersionPlanRequest $request)
    {
        $data = $request->except(['_token']);

        if ($this->plan->createNextVersion($data)) {
            $notification = [
                'status' => 200,
                'message' => 'New version created!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Versioning failed!',
                'alert-type' => 'error'
            ];
        }

        /* Render the response */
        if ($request->ajax()) {
            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);
            return response()->json([
                'response' => $notification['status'],
                'message' => $notification['message']
            ]);
        } else {
            abort(403, 'Direct access is not allowed.');
        };
    }


    public function email(EmailPlanRequest $request)
    {
        $data = $request->except(['_token']);

        if ($this->plan->emailToRecipient($data)) {
            $notification = [
                'status' => 200,
                'message' => 'Mail was sent!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Mail was not sent!',
                'alert-type' => 'error'
            ];
        }

        /* Response */
        if ($request->ajax()) {
            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);
            return response()->json([
                'response' => $notification['status'],
                'message' => $notification['message']
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