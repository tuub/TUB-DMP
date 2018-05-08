@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('section_form', $template, $section, $mode) }}

    {!! Form::model($section, ['method' => $method, 'route' => ['admin.section.' . $action, $section->id], 'class' => '', 'role' => 'form']) !!}
    <legend>{{ trans('admin/section.title.' . $mode) }}</legend>
    {!! Form::hidden('order', ($section->order ?? $position)) !!}
    {!! Form::hidden('template_id', $template->id) !!}
    {!! Form::hidden('return_route', $return_route) !!}
    <div class="row">
        <div class="form-group col-md-2">
            {!! Form::Label( 'keynumber', trans('admin/section.form.label.keynumber') ) !!}
            {!! Form::Text( 'keynumber', $section->keynumber ?? $position, array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('keynumber') ? 'form-error' : '') }}">{{ $errors->first('keynumber') }}</span>
        </div>
        <div class="control-group col-md-6 col-md-offset-16 text-right">
            <div class="controls">
                {!! Form::Label( 'is_active', trans('admin/section.form.label.is_active') ) !!}
                {!! Form::hidden('is_active', '0') !!}
                {!! Form::checkbox('is_active', 1, old('is_active', $section->is_active)) !!}
            </div>
            <div class="controls">
                {!! Form::Label( 'export_keynumber', trans('admin/section.form.label.export_keynumber') ) !!}
                {!! Form::hidden('export_keynumber', '0') !!}
                {!! Form::checkbox('export_keynumber', 1, old('export_keynumber', $section->export_keynumber)) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'name', trans('admin/section.form.label.name') ) !!}
            {!! Form::Text( 'name', Input::old('name'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'guidance', trans('admin/section.form.label.guidance') ) !!}
            {!! Form::Textarea( 'guidance', Input::old('guidance'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('guidance') ? 'form-error' : '') }}">{{ $errors->first('guidance') }}</span>
        </div>
    </div>
    <div class="col-md-24 text-center">
        {!! Form::submit(trans('admin/section.form.label.submit.' . $mode), array('class' => 'button btn btn-success')) !!}
        {!! HTML::link(URL::previous(), trans('form.label.cancel'), ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}

@stop