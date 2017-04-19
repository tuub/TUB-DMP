<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\MetadataRegistry;
use App\Project;
use App\Template;
use Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    protected $project;


    /**
     * ProjectController constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }


    /**
     * Collects hierarchical project data with various relations and counts,
     * and passes them to the dashboard. No dashboard without this method.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = $this->project
                    ->with('user', 'plans', 'data_source', 'plans.survey', 'plans.survey.template',
                        'metadata', 'metadata.metadata_registry', 'metadata.metadata_registry.content_type')
                    ->withCount('children')
                    ->withCount('plans')
                    ->where('user_id', auth()->user()->id)
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
                abort(403, 'Direct access is not allowed.');
            }
        } else {
            throw new NotFoundHttpException;
        }
    }


    /**
     * Receives request from edit project form (modal) and passes the data to
     * the intermediate method saveMetadata() in project model.
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request)
    {
        /* Get the project instance */
        $project = $this->project->findOrFail($request->id);

        /* Get the request data while kicking out non-metadata values */
        $data = $request->except(['_token', '_method', 'id']);

        /* Save the metadata (or not) and assign response variables */
        if ($project->saveMetadata($data)) {
            $notification = [
                'status'     => 200,
                'message'    => 'Project Metadata was successfully updated!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status'     => 500,
                'message'    => 'Project Metadata not updated!',
                'alert-type' => 'error'
            ];
        };

        /* Send the response*/
        if($request->ajax()) {

            $request->session()->flash('message', $notification['message']);
            $request->session()->flash('alert-type', $notification['alert-type']);

            return response()->json([
                'response' => $notification['status'],
                'message'  => $notification['message']
            ]);

        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }
}