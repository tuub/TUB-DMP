<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SortSectionRequest;
use App\Http\Requests\Admin\CreateSectionRequest;
use App\Http\Requests\Admin\UpdateSectionRequest;
use App\Section;
use App\Template;
use Illuminate\Http\Request;

class SectionController extends Controller {

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
     * @param $template_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Template $template)
    {
        $template = $this->template->find($template->id);
        $sections = $this->section->withCount('questions')->where('template_id', $template->id)->orderBy('order', 'asc')
                ->get();
        return view('admin.section.index', compact('template', 'sections'));
    }


    /**
     * Displays the form for creating a new section.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $section = new $this->section;
        $template = $this->template->where('id', $request->template)->first();
        $position = $this->section->getNextOrderPosition($template);
        return view('admin.section.new', compact('section','template', 'position'));
    }


    /**
     * Stores the new section and redirects to template's section index.
     *
     * @param \App\Http\Requests\Admin\CreateSectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSectionRequest $request)
    {
        $data = array_filter($request->all(), 'strlen');

        if ($section = $this->section->create($data)) {
            $notification = [
                'status' => 200,
                'message' => 'Successfully created the section!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Error while creating the section!',
                'alert-type' => 'error'
            ];
        }

        /* Create Flash session with return values for notification */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        return redirect()->route('admin.template.sections.index', $section->template->id);
    }


    /**
     * Displays the form for editing the specified section.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $section = $this->section->find($id);
        $templates = $this->template->get()->pluck('name', 'id');
        return view('admin.section.edit', compact('section','templates'));
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
        $section = $this->section->find($id);
        $data = $request->except('_token');
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });

        if ($section = $section->update($data)) {
            $notification = [
                'status' => 200,
                'message' => 'Successfully updated the section!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Error while updating the section!',
                'alert-type' => 'error'
            ];
        }

        /* Create Flash session with return values for notification */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        return redirect()->route('admin.template.sections.index', $request->get('template_id'));
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
        $section = $this->section->find($id);

        if ($section->delete()) {
            $notification = [
                'status' => 200,
                'message' => 'Successfully deleted the section!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Error while deleting the section!',
                'alert-type' => 'error'
            ];
        }

        /* Create Flash session with return values for notification */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        return redirect()->route('admin.template.sections.index', $section->template->id);
    }


    /**
     * Updates positions of the given sections set.
     *
     * @uses \App\Section::updatePositions
     * @param \App\Http\Requests\Admin\SortSectionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(SortSectionRequest $request) {
        $data = $request->all();

        if ($this->section->updatePositions($data)) {
            $notification = [
                'status' => 200,
                'message' => 'Sorting updated!',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'status' => 500,
                'message' => 'Sorting not updated!',
                'alert-type' => 'error'
            ];
        }

        /* Create Flash session with return values for notification */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        /* Create the response in JSON */
        if ($request->ajax()) {
            return response()->json([
                'response' => $notification['status'],
                'message' => $notification['message']
            ]);
        } else {
            abort(403, 'Direct access is not allowed.');
        };
    }
}