<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Admin\PlanRequest;

use App\Project;
use App\Plan;
use App\Template;

class PlanController extends Controller
{
    protected $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function index()
    {
        $plans = $this->plan->with('survey')->orderBy('updated_at', 'desc')->get();
        return view('admin.plan.index', compact('plans'));
    }

    public function create()
    {
        $plan = $this->plan;
        $plan->title = "Data Management Plan";
        $projects = Project::orderBy('identifier', 'asc')->get()->pluck('identifier','id');
        $templates = Template::get()->pluck('name','id');
        return view('admin.plan.new', compact('plan','projects','templates'));
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

        /* Create the redirect to index */
        return redirect()->route('admin.plan.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $plan = $this->plan->findOrFail($id);
        $projects = Project::orderBy('identifier', 'asc')->get()->pluck('identifier','id');
        return view('admin.plan.edit', compact('plan','projects','templates','versions'));
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = $this->plan->findOrFail($id);
        $data = $request->all();
        $plan->update($data);
        return Redirect::route('admin.dashboard');
    }

    public function destroy($id)
    {
        $plan = $this->plan->findOrFail($id);
        $plan->delete();
        return Redirect::route('admin.plan.index');
    }
}