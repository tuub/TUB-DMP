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
        $projects = $this->project->where( 'user_id', Auth::user()->id )->orderBy('updated_at', 'desc')->get();
        return view('dashboard', compact('projects'));
    }
}
