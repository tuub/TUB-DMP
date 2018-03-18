<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProjectMetadata;
use App\Http\Requests\Request;
use App\Http\Requests\Admin\CreateProjectMetadataRequest;
use App\Http\Requests\Admin\UpdateProjectMetadataRequest;
use App\Library\Sanitizer;
use App\Library\Notification;

/**
 * Class ProjectMetadataController
 *
 * @package App\Http\Controllers\Admin
 */
class ProjectMetadataController extends Controller
{
    protected $project_metadata;


    /**
     * ProjectMetadataController constructor.
     *
     * @param ProjectMetadata $project_metadata
     */
    public function __construct(ProjectMetadata $project_metadata)
    {
        $this->project_metadata = $project_metadata;
    }


    /**
     * @todo: Documentation
     */
    public function index()
    {

    }


    /**
     * @todo: Documentation
     */
    public function create()
    {

    }


    /**
     * @todo: Documentation
     *
     * @param CreateProjectMetadataRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProjectMetadataRequest $request)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* Validate input */

        /* The operation */
        $op = $this->project_metadata->create($data);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the project metadatum!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the project metadatum!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     * @todo: Documentation
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->project_metadata->findOrFail($id);
    }


    /**
     * @todo: Documentation
     *
     * @param $id
     */
    public function edit($id)
    {

    }


    /**
     * Updates the project metadatum with the given id.
     *
     * @param UpdateProjectMetadataRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectMetadataRequest $request, $id)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* The validation */

        /* Get object */
        $project_metadata = $this->project_metadata->findOrFail($id);

        /* The operation */
        $op = $project_metadata->update($data);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the project metadatum!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the project metadatum!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     * Deletes the project metadatum with the given id.
     *
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        /* Get object */
        $project_metadata = $this->project_metadata->find($id);

        /* The operation */
        $op = $project_metadata->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the project metadata!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the project metadata!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dasboard');
    }
}