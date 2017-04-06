<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\MetadataRegistry;
use App\Project;
use App\ProjectMetadata;
use App\Template;
use Auth;
use Carbon\Carbon;
use Request;

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
        $projects = $this->project
            ->with('user', 'plans', 'data_source', 'plans.survey', 'plans.survey.template', 'metadata', 'metadata.metadata_registry', 'metadata.metadata_registry.content_type')
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


    public function show($id)
    {
        $project = $this->project->with('metadata.metadata_registry')->findOrFail($id);
        if( $project) {
            if (Request::ajax()) {
                return $project->toJson();
            } else {
                return view('project.show', compact('project'));
            }
        }
    }


    public function edit($id)
    {
        $project = $this->project->findOrFail($id);

        if( $project ) {

            $projects = $this->project
                ->where('user_id', Auth::id())
                ->get()
                ->pluck('identifier','id')
                ->prepend('Select a parent','');

            $metadata_fields = $this->metadata_registry
                ->where('namespace', 'project')
                ->get();

            return view('project.edit', compact('project','projects','metadata_fields'));
        }
    }

    public function update(ProjectRequest $request)
    {
        //return response()->json($request->all());

        /* Get the project */
        $project = $this->project->findOrFail($request->id);

        /* Get the request data */
        $data = $request->except(['_token', '_method', 'id']);

        /* Save the metadata */
        $project->saveMetadata($data);

        if($request->ajax()) {
            return response()->json([
                'response' => 200,
                'msg' => 'Updated!'
            ]);
        } else {
            return response()->json([
                'response' => 500,
                'msg' => 'Error!'
            ]);
        }
    }
}