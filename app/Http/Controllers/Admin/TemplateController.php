<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateTemplateRequest;
use App\Http\Requests\Admin\UpdateTemplateRequest;
use App\Library\Notification;
use App\Library\Sanitizer;

class TemplateController extends Controller
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }


    public function index()
    {
        $templates = $this->template->get();
        return view('admin.template.index', compact('templates'));
    }


    public function create()
    {
        $template = new $this->template;
        $return_route = 'admin.dashboard';

        return view('admin.template.create', compact('template','return_route'));
    }


    public function store(CreateTemplateRequest $request)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* The uploaded file */
        $logo_file = $request->file('logo_file');

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route', 'logo_file'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* The operation */
        $template = $op = $this->template->create($data);
        if ($logo_file) {
            $logo_file_extension = $logo_file->extension();
            $logo_file = $logo_file->storePubliclyAs('images/logo', $template->id . '.' . $logo_file_extension, 'public_uploads');
            $template->logo_file = $logo_file;
            $template->save();
        }

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
        $return_route = 'admin.dashboard';

        return view('admin.template.edit', compact('template','return_route'));
    }


    public function update(UpdateTemplateRequest $request, $id)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* The uploaded file */
        $logo_file = $request->file('logo_file');
        $delete_logo_file = $request->file('delete_logo_file');

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route', 'logo_file', 'delete_logo_file'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get object */
        $template = $this->template->findOrFail($id);

        /* The operation */
        if (null === $delete_logo_file) {
            if (file_exists(public_path($logo_file))) {
                unlink(public_path($template->logo_file));
            }
            $data['logo_file'] = null;
        }
        if ($logo_file) {
            if (file_exists(public_path($logo_file))) {
                unlink(public_path($template->logo_file));
            }
            $logo_file_extension = $logo_file->extension();
            $logo_file = $logo_file->storePubliclyAs('images/logo', $template->id . '.' . $logo_file_extension, 'public_uploads');
            $data['logo_file'] = $logo_file;
        }
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
        if ($template->logo_file && file_exists(public_path($template->logo_file))) {
            unlink(public_path($template->logo_file));
        }
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