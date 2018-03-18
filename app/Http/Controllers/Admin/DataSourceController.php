<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateDataSourceRequest;
use App\Http\Requests\Admin\UpdateDataSourceRequest;
use App\Http\Requests\Admin\DeleteDataSourceRequest;
use App\DataSource;
use App\Library\Sanitizer;
use App\Library\Notification;
use Illuminate\Support\Facades\Redirect;


/**
 * Class DataSourceController
 *
 * @package App\Http\Controllers\Admin
 */
class DataSourceController extends Controller
{
    protected $data_source;


    /**
     * DataSourceController constructor.
     *
     * @param DataSource $data_source
     */
    public function __construct(DataSource $data_source)
    {
        $this->data_source = $data_source;
    }


    /**
     * Show all data sources.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data_sources = $this->data_source->orderBy('name', 'asc')->get();
        return view('admin.data_source.index', compact('data_sources'));
    }


    /**
     * Renders the create form for new data source.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data_source = $this->data_source;
        return view('admin.data_source.new', compact('data_source'));
    }


    /**
     * Stores a new data source instance.
     *
     * @param CreateDataSourceRequest $request
     * @return Redirect
     */
    public function store(CreateDataSourceRequest $request)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* Validate input */

        /* The operation */
        $op = $this->data_source->create($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the data source!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the data source!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     * Renders the edit form for the given data source id.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data_source = $this->data_source->findOrFail($id);
        return view('admin.data_source.edit', compact('data_source'));
    }


    /**
     * Saves new values for the given data source id.
     *
     * @param UpdateDataSourceRequest $request
     * @param $id
     *  About Param
     *
     * @return \Illuminate\Http\RedirectResponse
     *  About Return Value
     *
     */
    public function update(UpdateDataSourceRequest $request, $id)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* The validation */

        /* Get object */
        $data_source = $this->data_source->findOrFail($id);

        /* The operation */
        $op = $data_source->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the data source!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the data source!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    /**
     * Deletes data source intance with the given id.
     *
     * @param DeleteDataSourceRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeleteDataSourceRequest $request, $id)
    {
        /* Get object */
        $data_source = $this->data_source->findOrFail($id);

        /* The operation */
        $op = $data_source->delete();

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the data source!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the data source!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }
}