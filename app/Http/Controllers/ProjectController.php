<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\MetadataRegistry;
use App\Project;
use App\Template;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $project;
    protected $metadata_registry;

    public function __construct(Project $project, MetadataRegistry $metadata_registry)
    {
        $this->project = $project;
        $this->metadata_registry = $metadata_registry;
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
            ->with('metadata.metadata_registry')
            ->withCount('children')
            ->withCount('plans')
            ->where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toHierarchy();

        // For Modals
        $templates = Template::get();

        return view('dashboard', compact('projects', 'templates'));
    }

    public function edit($id)
    {
        $project = $this->project->findOrFail($id);
        if( $project ) {
            $projects = $this->project->where('user_id', Auth::id())->get()->pluck('identifier','id')->prepend('Select a parent','');
            $metadata_fields = $this->metadata_registry->where('namespace', 'project')->get();
            //dd($metadata_fields);
            return view('project.edit', compact('project','projects','metadata_fields'));
        }
        throw new NotFoundHttpException;
    }

    public function update(ProjectRequest $request, $id)
    {
        $project = $this->project->findOrFail($id);
        $data = $request->all();
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $project->update($data);
        return Redirect::route('dashboard');
    }
}
