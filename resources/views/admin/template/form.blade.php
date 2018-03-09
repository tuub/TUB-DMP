@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('template_form', $template, $mode) }}

    {!! Form::model($template, ['method' => $method, 'route' => ['admin.template.' . $action, $template->id], 'class' => '', 'role' => 'form', 'files' => true]) !!}
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
                {!! Form::Label( 'is_active', trans('admin/template.form.label.is_active') ) !!}
                {!! Form::hidden('is_active', '0') !!}
                {!! Form::checkbox('is_active', 1, old('is_active', $template->is_active)) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'description', trans('admin/template.form.label.description') ) !!}
            {!! Form::Textarea( 'description', Input::old('description'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('description') ? 'form-error' : '') }}">{{ $errors->first('description') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'copyright', trans('admin/template.form.label.copyright') ) !!}
            {!! Form::Textarea( 'copyright', Input::old('copyright'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('copyright') ? 'form-error' : '') }}">{{ $errors->first('copyright') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'logo_file', trans('admin/template.form.label.logo_file') ) !!}
            @if ($template->logo_file)
                <p>
                    {!! HTML::image(\App\Library\ImageFile::getVersion($template->logo_file, 'export'), $template->logo_file, ['class' => 'thumbnail', 'style' => 'width: 100px;']) !!}
                </p>
                <div class="row">
                    <div class="form-group col-md-24">
                        {!! Form::Label( 'delete_logo_file', trans('admin/template.form.label.delete_logo_file') ) !!}
                        {!! Form::hidden('delete_logo_file', '0') !!}
                        {!! Form::checkbox('delete_logo_file', 1, null, ['class' => 'classic']) !!}
                    </div>
                </div>
            @endif
            {!! Form::file( 'logo_file', array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('logo_file') ? 'form-error' : '') }}">{{ $errors->first('logo_file') }}</span>
        </div>
    </div>
    <div class="col-md-24 text-center">
        {!! Form::submit(trans('admin/template.form.label.submit.' . $mode), array('class' => 'button btn btn-success')) !!}
        {!! HTML::link(URL::previous(), trans('form.label.cancel'), ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}

@stop