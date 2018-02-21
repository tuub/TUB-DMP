<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Project;
use App\Plan;
use App\Template;
use App\Http\Requests\Admin\CreatePlanRequest;
use App\Http\Requests\Admin\UpdatePlanRequest;
use App\Http\Requests\Admin\DeletePlanRequest;
use App\Library\Sanitizer;
use App\Library\Notification;


class PlanController extends Controller
{
    protected $plan;
    protected $project;


    public function __construct(Plan $plan, Project $project)
    {
        $this->plan = $plan;
        $this->project = $project;
    }


    // FIXME: Do we really need the $project here, can we solve it with relation?
    public function index(Project $project)
    {
        $project = $this->project->find($project->id);
        $plans = $this->plan->where('project_id', $project->id)->with('survey')->orderBy('updated_at', 'desc')->get();
        return view('admin.plan.index', compact('plans', 'project'));
    }


    // FIXME:
    // really $request->project or $request->project_id?
    // $plan->title?
    // New-View or Create-View?
    // Template?
    public function create(CreatePlanRequest $request)
    {
        $project = $this->project->where('id', $request->project)->first();
        $plan = new $this->plan;
        $plan->title = "Data Management Plan";
        $templates = Template::get()->pluck('name','id');
        return view('admin.plan.new', compact('plan','project','templates'));
    }


    /**
     * Stores a new plan instance with accompanying survey instance via
     * model method createWithSurvey()
     *
     * @param PlanRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePlanRequest $request)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* Validate input */

        /* Get the project object */
        $project = $this->project->find($data['project_id']);

        /* FIXME: Generalize?
        The operation Create Plan with corresponding Survey */
        $op = $this->plan->createWithSurvey($data['title'], $data['project_id'], $data['version'], $data['template_id']);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the plan!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the plan!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.project.plans.index', $project);
    }


    public function show($id)
    {
        //
    }


    // FIXME:
    // Plan?
    public function edit($id)
    {
        $plan = $this->plan->findOrFail($id);
        $projects = Project::where('user_id', $plan->project->user->id)->orderBy('identifier', 'asc')->get()->pluck('identifier','id');
        return view('admin.plan.edit', compact('plan','projects'));
    }


    public function update(UpdatePlanRequest $request, $id)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* The validation */

        /* Get the project object */
        $project = $this->project->find($request->project_id);

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

        return redirect()->route('admin.project.plans.index', $project);
    }

    public function destroy(DeleteQuestionRequest $request, $id)
    {
        /* Get the project object */
        $project = $this->project->find($request->project_id);

        /* Get object */
        $plan = $this->plan->find($id);

        /* The operation */
        $op = $plan->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the plan!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the plan!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.section.questions.index', $project);
    }
}