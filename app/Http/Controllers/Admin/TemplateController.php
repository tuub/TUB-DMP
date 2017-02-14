<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Template;
use App\Institution;

use App\Http\Requests\Admin\UpdateTemplateRequest;

use View;
use Redirect;
use Session;


class TemplateController extends Controller
{
    protected $template;
    protected $institution;

    public function __construct( Template $template, Institution $institution )
    {
        $this->template = $template;
        $this->institution = $institution;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = $this->template->all();
        return View::make('admin.template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $template = new $this->template;
        $institutions = $this->institution->all()->lists('name', 'id');
        return View::make('admin.template.new', compact('template','institutions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = new $this->template;
        $template->name       = $request->get('name');
        $template->institution_id = $request->get('institution_id');
        $template->is_active      = $request->get('is_active');
        $template->save();
        Session::flash('message', 'Successfully created the template!');
        return Redirect::route('admin.template.index');
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
        $template = $this->template->find($id);
        $institutions = $this->institution->all()->lists('name', 'id');
        return View::make('admin.template.edit', compact('template','institutions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTemplateRequest $request, $id)
    {
        $template = $this->template->find($id);
        $data = $request->except('_token');
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $template->update( $data );
        return Redirect::route('admin.template.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = $this->template->find($id);
        $template->delete();
        Session::flash('message', 'Successfully deleted template!');
        return Redirect::route('admin.template.index');
    }
}


