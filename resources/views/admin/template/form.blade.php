@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {!! Form::model($template, ['method' => $method, 'route' => ['admin.template.' . $action, $template->id], 'class' => '', 'role' => 'form']) !!}
    <legend>{{ trans('admin/template.title.' . $mode) }}</legend>
    {!! Form::hidden('return_route', $return_route) !!}
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::Label( 'name', trans('admin/template.form.label.name') ) !!}
            {!! Form::Text( 'name', Input::old('name'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>
        </div>
        <div class="control-group col-md-4 col-md-offset-14 text-right">
            <div class="controls">
                {!! Form::Label( 'is_active', trans('admin/section.form.label.is_active') ) !!}
                {!! Form::hidden('is_active', '0') !!}
                {!! Form::checkbox('is_active', 1, old('is_active', $template->is_active)) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'institution_id', trans('admin/template.form.label.institution') ) !!}
            {!! Form::select('institution_id', [null => 'None'] + $institutions->toArray(), $template->institution_id, array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('institution_id') ? 'form-error' : '') }}">{{ $errors->first('institution_id') }}</span>
        </div>
    </div>
    <div class="col-md-24 text-center">
        {!! Form::submit(trans('admin/template.form.label.submit.' . $mode), array('class' => 'button btn btn-success')) !!}
        {!! HTML::link(URL::previous(), trans('form.label.cancel'), ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}

@stop