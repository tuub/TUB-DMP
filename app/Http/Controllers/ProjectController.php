<?php

namespace App\Http\Controllers;

use App\Project;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }


    public function index()
    {
        //$project = $this->project->create(['identifier' => 'COURTNEY-123', 'user_id' => 1]);
        //$subproject1 = $project->children()->create(['identifier' => 'COURTNEY-123-01', 'user_id' => 1]);
        //$subproject2 = $project->children()->create(['identifier' => 'COURTNEY-123-02', 'user_id' => 1]);
        //$subproject3 = $project->children()->create(['identifier' => 'COURTNEY-123-03', 'user_id' => 1]);

        //$parent = $project->parent()->get();
        //$children = $project->children()->get();

        //$nestedList = $this->project->getNestedList('identifier','id','<li>');
        //dd($nestedList);

        $projects = $this->project
            ->where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toHierarchy();

        return view('dashboard', compact('projects'));
    }
}
