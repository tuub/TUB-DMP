<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\MetadataField;
use App\Project;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $project;
    protected $metadata_field;

    public function __construct(Project $project, MetadataField $metadata_field)
    {
        $this->project = $project;
        $this->metadata_field = $metadata_field;
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

    public function edit($id)
    {
        $project = $this->project->findOrFail($id);
        if( $project ) {
            $projects = $this->project->where('user_id', Auth::id())->get()->pluck('identifier','id')->prepend('Select a parent','');
            $metadata_fields = $this->metadata_field->where('namespace', 'project')->get();
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
