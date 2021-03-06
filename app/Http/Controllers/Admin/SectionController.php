<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SortSectionRequest;
use App\Http\Requests\Admin\CreateSectionRequest;
use App\Http\Requests\Admin\UpdateSectionRequest;
use App\Section;
use App\Template;
use Illuminate\Http\Request;
use App\Library\Sanitizer;
use App\Library\Notification;


/**
 * Class SectionController
 *
 * @package App\Http\Controllers\Admin
 */
class SectionController extends Controller
{
    protected $section;
    protected $template;


    /**
     * SectionController constructor.
     *
     * @param Section  $section
     * @param Template $template
     */
    public function __construct(Section $section, Template $template)
    {
        $this->section = $section;
        $this->template = $template;
    }


    /**
     * Gets a section list of the specified template.
     *
     * @param Template $template
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Template $template)
    {
        $template = $this->template->find($template->id);
        $sections = $this->section->withCount('questions')->where('template_id', $template->id)->orderBy('order')->get();

        return view('admin.section.index', compact('template', 'sections'));
    }


    /**
     * Displays the form for creating a new section for the given Template (in request).
     *
     * @todo: Refactor so it does not need a request var here! See also Admin\QuestionController.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $template = $this->template->where('id', $request->template)->first();
        $section = new $this->section;
        $position = $this->section->getNextOrderPosition($template);
        $return_route = 'admin.template.sections.index';

        return view('admin.section.create', compact('template','section','position', 'return_route'));
    }


    /**
     * Stores the new section and redirects to template's section index.
     *
     * @param \App\Http\Requests\Admin\CreateSectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSectionRequest $request)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* The operation */
        $template = $this->template->find($data['template_id']);
        $op = $this->section->create($data);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the section!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the section!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $template);
    }


    /**
     * Displays the form for editing the specified section.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $section = $this->section->findOrFail($id);
        $template = $section->template;
        $position = $section->order;
        $return_route = 'admin.template.sections.index';

        return view('admin.section.edit', compact('section','template', 'return_route', 'position'));
    }


    /**
     * Updates the specified section and redirects to template's section index.
     *
     * @param \App\Http\Requests\Admin\UpdateSectionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSectionRequest $request, $id)
    {
        /* The return route */
        $return_route = $request->return_route;

        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['return_route'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get object */
        $section = $this->section->findOrFail($id);

        /* The operation */
        $op = $section->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the section!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the section!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route($return_route, $section->template_id);
    }


    /**
     * Deletes the specified section and redirects to template's section index.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        /* Get object */
        $section = $this->section->find($id);

        /* The operation */
        $op = $section->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the section!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the section!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.template.sections.index', $section->template->id);
    }


    /**
     * Updates positions of the given sections set.
     *
     * @uses \App\Section::updatePositions
     * @param \App\Http\Requests\Admin\SortSectionRequest $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function sort(SortSectionRequest $request) {

        if ($request->ajax()) {

            /* The operation */
            $op = $this->section->updatePositions($request->all());

            /* The notification */
            if ($op) {
                $notification = new Notification(200, 'Sorting updated!', 'success');
            } else {
                $notification = new Notification(500, 'Sorting not updated!', 'error');
            }

            /* The JSON response */
            return $notification->toJson($request);
        }

        return null;
    }
}