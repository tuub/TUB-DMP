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
        $plans = $this->plan->all();
        return view('admin.plan.index', compact('plans'));
    }

    public function create()
    {
        $plan = $this->plan;
        $plan->title = "Data Management Plan";
        $projects = Project::all()->pluck('identifier','id')->prepend('Select a project',null);
        $templates = Template::all()->pluck('name','id')->prepend('Select a template',null);
        $versions = ['1' => 1, '2' => 2, '3' => 3];
        return view('admin.plan.new', compact('plan','projects','templates','versions'));
    }

    public function store(PlanRequest $request)
    {
        $data = $request->all();
        $this->plan->create($data);
        return Redirect::route('admin.plan.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $plan = $this->plan->findOrFail($id);
        $projects = Project::all()->pluck('identifier','id')->prepend('Select a project',null);
        $templates = Template::all()->pluck('name','id')->prepend('Select a template',null);
        $versions = ['1' => 1, '2' => 2, '3' => 3];
        return view('admin.plan.edit', compact('plan','projects','templates','versions'));
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = $this->plan->findOrFail($id);
        $data = $request->all();
        $this->plan->update($data);
        return Redirect::route('admin.dashboard');
    }

    public function destroy($id)
    {
        $plan = $this->plan->findOrFail($id);
        $this->plan->delete();
        return Redirect::route('admin.plan.index');
    }
}