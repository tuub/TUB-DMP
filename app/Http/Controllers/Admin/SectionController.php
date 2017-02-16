<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Section;
use App\Template;

use App\Http\Requests\Admin\CreateSectionRequest;
use App\Http\Requests\Admin\UpdateSectionRequest;

use Request;
use Redirect;
use View;
use Session;

class SectionController extends Controller {

    protected $section;
    protected $template;


    public function __construct( Section $section, Template $template )
    {
        $this->section = $section;
        $this->template = $template;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = $this->section->all();
        return View::make('admin.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = new $this->section;
        $templates = $this->template->all()->lists('name', 'id');
        return View::make('admin.section.new', compact('section','templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSectionRequest $request)
    {
        $section = new $this->section;
        $section->name          = $request->get('name');
        $section->template_id   = $request->get('template_id');
        $section->is_active     = $request->get('is_active');
        $section->save();
        Session::flash('message', 'Successfully created the section!');
        return Redirect::route('admin.section.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = $this->section->find($id);
        $templates = $this->template->all()->lists('name', 'id');
        return View::make('admin.section.edit', compact('section','templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectionRequest $request, $id)
    {
        $section = $this->section->find($id);
        $data = $request->except('_token');
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $section->update( $data );
        return Redirect::route('admin.section.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = $this->section->find($id);
        $section->delete();
        Session::flash('message', 'Successfully deleted section!');
        return Redirect::route('admin.section.index');
    }










    /*

    public function edit($id)
    {
        $section = $this->section->find($id);
        $questions = $section->questions()->get();
        session(['redirect' => Request::server('HTTP_REFERER')]);
        return View::make('admin.section.edit', compact('section','questions'));
    }

    public function update( UpdateSectionRequest $request )
    {
        if($request->session()->has('redirect'))
        {
            $redirect = session('redirect');
        } else
        {
            $redirect = $request->headers->get('referer');;
        }
        $section = $this->section->find($request->id);
        $data = $request->except('_token');
        $section->update( $data );
        return Redirect::to($redirect);
    }
    */
}