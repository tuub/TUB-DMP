<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateTemplateRequest;
use App\Http\Requests\Admin\UpdateTemplateRequest;
use App\Library\Notification;
use App\Library\Sanitizer;
use App\Library\ImageFile;
use Illuminate\Support\Facades\Storage;


/**
 * Class TemplateController
 *
 * @package App\Http\Controllers\Admin
 */
class TemplateController extends Controller
{
    protected $template;


    /**
     * TemplateController constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }


    /**
     * Renders the templates index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $templates = $this->template->get();
        return view('admin.template.index', compact('templates'));
    }


    /**
     * Renders create form for a new template.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $template = new $this->template;
        $return_route = 'admin.dashboard';

        return view('admin.template.create', compact('template','return_route'));
    }


    /**
     * Stores a new template.
     *
     * @uses ImageFile::createVersions()
     * @param CreateTemplateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        /**
         * The operation
         *
         * For testing, uncomment the following random filename generator:
         * $data['name'] = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
         */
        $template = $op = $this->template->create($data);

        if ($logo_file) {
            $options = [
                'disk' => 'public_logo',
                'identifier' => $template->id,
                'extension' => $logo_file->extension()
            ];

            $template->logo_file = Storage::disk($options['disk'])->url('/') . $options['identifier'] . '/';
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


    /**
     * Renders the edit form for the given template ID.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $template = $this->template->findOrFail($id);
        $return_route = 'admin.dashboard';

        return view('admin.template.edit', compact('template','return_route'));
    }


    /**
     * Updates template with the given id.
     *
     * See https://github.com/laravel/framework/issues/13610#issuecomment-374750518
     *
     * @uses ImageFile::deleteVersions()
     * @uses ImageFile::createVersions()
     * @param UpdateTemplateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
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
        if ($delete_logo_file !== null) {
            ImageFile::deleteVersions($template->id, ['disk' => 'public_logo']);
            $data['logo_file'] = null;
        }
        if ($logo_file) {

            $options = [
                'disk' => 'public_logo',
                'identifier' => $template->id,
                'extension' => $logo_file->extension()
            ];

            $data['logo_file'] = Storage::disk($options['disk'])->url('/') . $options['identifier'] . '/';

            ImageFile::deleteVersions($options['identifier'], $options);
            ImageFile::createVersions($logo_file, $options);

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


    /**
     * Deletes template with the given ID.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
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


    /**
     * Copies the template with the given ID (in the request).
     *
     * @todo: Documentation
     *
     * @uses Template::copy()
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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