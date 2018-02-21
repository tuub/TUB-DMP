<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateTemplateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Template;
use App\Institution;
use App\Http\Requests\Admin\UpdateTemplateRequest;
use Session;
use App\Library\Notification;
use App\Library\Sanitizer;


class TemplateController extends Controller
{
    protected $template;
    protected $institution;

    public function __construct( Template $template, Institution $institution )
    {
        $this->template = $template;
        $this->institution = $institution;
    }


    public function index()
    {
        $templates = $this->template->get();
        return view('admin.template.index', compact('templates'));
    }


    public function create()
    {
        $template = new $this->template;
        $institutions = $this->institution->get()->pluck('name', 'id');
        $return_route = 'admin.dashboard';

        return view('admin.template.create', compact('template','institutions', 'return_route'));
    }


    public function store(CreateTemplateRequest $request)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* The operation */
        $template = $op = $this->template->create($data);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the template!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the template!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $template);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $template = $this->template->find($id);
        $institutions = $this->institution->get()->pluck('name', 'id');
        $return_route = 'admin.dashboard';

        return view('admin.template.edit', compact('template','institutions', 'return_route'));
    }


    public function update(UpdateTemplateRequest $request, $id)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get object */
        $template = $this->template->findOrFail($id);

        /* The operation */
        $op = $template->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the template!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the template!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $template);
    }


    public function destroy(Request $request, $id)
    {
        /* Get object */
        $template = $this->template->find($id);

        /* The operation */
        $op = $template->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the template!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the template!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    public function copy(Request $request)
    {
        $template = $this->template->findOrFail($request->id);

        /* The operation */
        $op = $template->copy();

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully copied the template!', 'success');
        } else {
            $notification = new Notification(500, 'Error while copying the template!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }
}