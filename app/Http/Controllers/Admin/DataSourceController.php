<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DataSourceRequest;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Admin\PlanRequest;

use App\Project;
use App\DataSource;

class DataSourceController extends Controller
{
    protected $data_source;

    public function __construct(DataSource $data_source)
    {
        $this->data_source = $data_source;
    }

    public function index()
    {
        $data_sources = $this->data_source->orderBy('name', 'asc')->get();
        return view('admin.data_source.index', compact('data_sources'));
    }

    // FIXME:
    public function create()
    {
        $data_source = $this->data_source;
        return view('admin.data_source.new', compact('data_source'));
    }


    /**
     * Stores a new plan instance with accompanying survey instance via
     * model method createWithSurvey()
     *
     * @param PlanRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DataSourceRequest $request)
    {
        /* Filter out all empty inputs */
        $data = array_filter($request->all(), 'strlen');

        /* Create DataSource with corresponding Survey */
        if ($this->data_source->create($data)) {
            $notification = [
                'status'     => 200,
                'message'    => 'Data source was successfully created!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status'     => 500,
                'message'    => 'Data source was not created!',
                'alert-type' => 'error'
            ];
        }

        /* Create Flash session with return values for notification */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        /* Create the redirect to index */
        return redirect()->route('admin.dashboard');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data_source = $this->data_source->findOrFail($id);
        return view('admin.data_source.edit', compact('data_source'));
    }

    public function update(DataSourceRequest $request, $id)
    {
        $data_source = $this->data_source->findOrFail($id);
        $data = $request->all();
        $data_source->update($data);
        return Redirect::route('admin.data_source.index');
    }

    public function destroy($id)
    {
        $data_source = $this->data_source->findOrFail($id);
        $data_source->delete();
        return Redirect::route('admin.data_source.index');
    }
}