<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Project;
use App\Plan;
use App\Template;
use App\Http\Requests\Admin\CreatePlanRequest;
use App\Http\Requests\Admin\UpdatePlanRequest;
use App\Library\Sanitizer;
use App\Library\Notification;


/**
 * Class PlanController
 *
 * @package App\Http\Controllers\Admin
 */
class PlanController extends Controller
{
    protected $plan;
    protected $project;


    /**
     * Constructor.
     *
     * @param Plan $plan
     * @param Project $project
     */
    public function __construct(Plan $plan, Project $project)
    {
        $this->plan = $plan;
        $this->project = $project;
    }


    // FIXME: Do we really need the $project here, can we solve it with relation?


    /**
     * Index of plans for given project
     *
     * @param Project $project
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function index(Project $project)
    {
        $view_name = 'admin.plan.index';

        $plans = $this->plan->where('project_id', $project->id)->with('survey')->orderBy('updated_at', 'desc')->get();

        return view($view_name, compact('plans', 'project'));
    }


    /**
     * Renders create form.
     *
     * @todo: Had old FIXME: really $request->project or $request->project_id?
     * @todo: Had old FIXME: $plan->title?
     * @todo: Had old FIXME: New-View or Create-View?
     * @todo: Had old FIXME: Template?
     *
     * @param CreatePlanRequest $request
     * @return mixed
     */
    public function create(CreatePlanRequest $request)
    {
        $view_name = 'admin.plan.create';
        $return_route = 'admin.project.plans.index';

        $project = $this->project->where('id', $request->project)->first();
        $plan = new $this->plan;
        $plan->title = trans('plan.create.input.title.default');
        $plan->version = trans('plan.create.input.version.default');
        $templates = Template::orderBy('name', 'asc')->get()->pluck('name','id');

        return view($view_name, compact('plan','project','templates', 'return_route'));
    }


    /**
     * Stores a new plan instance with accompanying survey instance via
     * model method createWithSurvey()
     *
     * @uses Sanitizer::cleanUp()
     * @uses Notification::toSession()
     * @uses Plan::createWithSurvey()
     * @param CreatePlanRequest $request
     * @return mixed
     */
    public function store(CreatePlanRequest $request)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* Validate */

        /* Get the project object */
        $project = $this->project->find($data['project_id']);

        /* The operation Create Plan with corresponding Survey */
        $op = $this->plan->createWithSurvey($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the plan!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the plan!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $project);
    }


    /**
     * Renders edit form for given plan id.
     *
     * @todo: Had old FIXME: Plan?
     *
     * @param string $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function edit($id)
    {
        $view_name = 'admin.plan.edit';
        $return_route = 'admin.project.plans.index';

        $plan = $this->plan->findOrFail($id);
        $project = $plan->project;
        $projects = $this->project->where('user_id', $plan->project->user->id)
            ->orderBy('identifier')
            ->get()
            ->pluck('identifier','id');
        $templates = Template::orderBy('name', 'asc')->get()->pluck('name','id');

        return view($view_name, compact('plan','project', 'projects', 'templates', 'return_route'));
    }


    /**
     * Updates an existing plan instance with given request data for given id.
     *
     * @todo: Check if ID in $request and probably save the extra param $id.
     *
     * @uses Sanitizer::cleanUp()
     * @uses Notification::toSession()
     * @param UpdatePlanRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(UpdatePlanRequest $request, $id) : RedirectResponse
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get the project object */
        $project = $this->project->find($data['project_id']);

        /* Get object */
        $plan = $this->plan->findOrFail($id);

        /* The operation */
        $op = $plan->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the plan!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the plan!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $project);
    }


    /**
     * Deletes an existing plan instance with given plan id.
     *
     * @todo: Can we use a dynamic return_route? Where should that come from?
     *
     * @uses Notification::toSession()
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id) : RedirectResponse
    {
        /* The return route */
        $return_route = 'admin.project.plans.index';

        /* Get object */
        $plan = $this->plan->find($id);

        /* Get the project object */
        $project = $plan->project;

        /* The operation */
        $op = $plan->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the plan!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the plan!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $project);
    }
}