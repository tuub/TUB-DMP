<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Admin\PlanRequest;

use App\Project;
use App\Plan;
use App\Template;

class PlanController extends Controller
{
    protected $plan;
    protected $project;

    public function __construct(Plan $plan, Project $project)
    {
        $this->plan = $plan;
        $this->project = $project;
    }

    public function index(Project $project)
    {
        $project = $this->project->find($project->id);
        $plans = $this->plan->where('project_id', $project->id)->with('survey')->orderBy('updated_at', 'desc')->get();
        return view('admin.plan.index', compact('plans', 'project'));
       }

    public function create(Request $request)
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
    public function store(PlanRequest $request)
    {
        /* Filter out all empty inputs */
        $data = array_filter($request->all(), 'strlen');
        $project = $this->project->find($data['project_id']);

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

        /* Create the redirect to index */
        return redirect()->route('admin.project.plans.index', $project);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $plan = $this->plan->findOrFail($id);
        $projects = Project::where('user_id', $plan->project->user->id)->orderBy('identifier', 'asc')->get()->pluck('identifier','id');
        return view('admin.plan.edit', compact('plan','projects','templates','versions'));
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = $this->plan->findOrFail($id);
        $project = $this->project->find($request->project_id);
        $data = $request->all();
        $plan->update($data);
        return Redirect::route('admin.project.plans.index', $project);
    }

    public function destroy($id)
    {
        $plan = $this->plan->findOrFail($id);
        $project = $plan->project;
        $plan->delete();
        return Redirect::route('admin.project.plans.index', $project);
    }
}