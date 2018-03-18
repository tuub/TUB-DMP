<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Requests\EmailPlanRequest;
use App\Http\Requests\SnapshotPlanRequest;
use App\Plan;
use App\Template;
use App\Library\Sanitizer;
use App\Library\Notification;
//use Event;
//use App\Events\PlanUpdated;
//use App\HtmlOutputFilter;
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


    /**
     * PlanController constructor.
     *
     * @param Template $template
     * @param Plan     $plan
     */
    public function __construct(Template $template, Plan $plan)
    {
        $this->template = $template;
        $this->plan = $plan;
    }


    /**
     * Stores a new plan instance with accompanying survey instance via
     * model method createWithSurvey()
     *
     * @param CreatePlanRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePlanRequest $request)
    {
        if ($request->ajax()) {
            /* Clean input */
            $dirty = new Sanitizer($request);
            $data = $dirty->cleanUp();

            /* Validate input */

            /* The operation */
            $op = $this->plan->createWithSurvey($data);

            /* Notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully created the plan!', 'success');
            } else {
                $notification = new Notification(500, 'Error while creating the plan!', 'error');
            }

            /* The JSON response */
            return $notification->toJson($request);
        }

        return null;
    }


    /**
     * @todo: Documentation
     *
     * @param Request $request
     * @param $id
     * @return null|string
     * @throws ModelNotFoundException
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $plan = $this->plan->findOrFail($id);

            if ($plan) {
                return $plan->toJson();
            }
        }

        return null;
    }


    /**
     * Updates the plan instance.
     *
     * @param UpdatePlanRequest $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(UpdatePlanRequest $request)
    {
        if ($request->ajax()) {

            /* Clean input */
            $dirty = new Sanitizer($request);
            $data = $dirty->cleanUp();

            /* The validation */

            /* Get object */
            $plan = $this->plan->findOrFail($data['id']);

            /* The operation */
            $op = $plan->update($data);

            /* Notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully updated the plan!', 'success');
            } else {
                $notification = new Notification(500, 'Error while updating the plan!', 'error');
            }

            return $notification->toJson($request);
        }

        return null;
    }


    /**
     * @todo: Documentation
     *
     * @param SnapshotPlanRequest $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function snapshot(SnapshotPlanRequest $request)
    {
        if ($request->ajax()) {

            /* Clean input */
            $dirty = new Sanitizer($request);
            $data = $dirty->cleanUp();

            /* The validation */

            /* Get object */
            $plan = $this->plan->find($data['id']);

            /* The operation */
            $op = $plan->createSnapshot($data);

            /* Type of operation */
            $op_result = 'snapshot';
            if (isset($data['clone_current'])) {
                $op_result .= ' and new version';
            }

            /* Notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully created the ' . $op_result . '!', 'success');
            } else {
                $notification = new Notification(500, 'Error while creating the ' . $op_result . '!', 'error');
            }

            return $notification->toJson($request);
        }

        return null;
    }


    /**
     * @todo: Documentation
     *
     * @param EmailPlanRequest $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function email(EmailPlanRequest $request)
    {
        if ($request->ajax()) {

            /* Clean input */
            $dirty = new Sanitizer($request);
            $data = $dirty->cleanUp();

            /* The validation */

            // FIXME: $this->plan?
            /* The operation */
            $op = $this->plan->emailToRecipient($data);

            /* Notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully emailed the plan!', 'success');
            } else {
                $notification = new Notification(500, 'Error while emailing the plan!', 'error');
            }

            return $notification->toJson($request);
        }

        return null;
    }


    /**
     * @todo: Documentation
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|null
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {

            /* Get object */
            $plan = $this->plan->findOrFail($request->id);

            /* The operation */
            $op = $plan->delete();

            /* The notification */
            if ($op) {
                $notification = new Notification(200, 'Successfully deleted the plan!', 'success');
            } else {
                $notification = new Notification(500, 'Error while deleting the plan!', 'error');
            }

            return $notification->toJson($request);
        }

        return null;
    }


    /**
     * @todo: Documentation / deprecated?
     *
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function export($id)
    {
        $plan = $this->plan->findOrFail($id);

        return $plan->exportPlan();
    }
}