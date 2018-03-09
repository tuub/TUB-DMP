<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateTemplateRequest;
use App\Http\Requests\Admin\UpdateTemplateRequest;
use App\Library\Notification;
use App\Library\Sanitizer;
use App\Library\ImageFile;

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
        //$data['name'] = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
        $template = $op = $this->template->create($data);
        if ($logo_file) {
            $options = [
                'storage_path' => 'images/logo/',
                'identifier' => $template->id,
                'extension' => $logo_file->extension(),
            ];

            $template->logo_file = $options['storage_path'] . $options['identifier'] . '/';
            $template->save();

            ImageFile::createVersions($logo_file, $options);
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
        $delete_logo_file = $request->delete_logo_file;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route', 'logo_file', 'delete_logo_file'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get object */
        $template = $this->template->findOrFail($id);

        /* The operation */
        if (null !== $delete_logo_file) {
            ImageFile::deleteVersions($logo_file, ['disk' => 'public_logo']);
            $data['logo_file'] = null;
        }
        if ($logo_file) {

            $options = [
                'storage_path' => 'images/logo/',
                'identifier' => $template->id,
                'extension' => $logo_file->extension(),
            ];

            ImageFile::deleteVersions($logo_file, ['disk' => 'public_logo']);
            ImageFile::createVersions($logo_file, $options);
            $data['logo_file'] = $options['storage_path'] . $options['identifier'] . '/';
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
        if ($template->logo_file) {

            ImageFile::deleteVersions($template->logo_file, ['disk' => 'public_logo']);
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