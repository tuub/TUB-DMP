@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('plan_form', $project, $plan, $mode) }}

    {!! Form::model($plan, ['method' => $method, 'route' => ['admin.plan.' . $action, $plan->id], 'class' => '', 'role' => 'form', 'files' => true]) !!}
    <legend>{{ trans('admin/plan.title.' . $mode) }}</legend>
    {!! Form::hidden('project_id', $project->id) !!}
    {!! Form::hidden('return_route', $return_route) !!}
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::Label( 'title', trans('admin/plan.form.label.title') ) !!}
            {!! Form::Text( 'title', Input::old('title'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('title') ? 'form-error' : '') }}">{{ $errors->first('title') }}</span>
        </div>
        <div class="control-group col-md-4 col-md-offset-14 text-right">
            <div class="controls">
                {!! Form::Label( 'is_active', trans('admin/plan.form.label.is_active') ) !!}
                {!! Form::hidden('is_active', '0') !!}
                {!! Form::checkbox('is_active', 1, old('is_active', $plan->is_active)) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'template_id', trans('admin/plan.form.label.template') ) !!}
            {!! Form::select('template_id', $templates->toArray(), $plan->template->id ?? null, ['class' => 'form-control']) !!}
            <span class="help-block {{ ($errors->first('template_id') ? 'form-error' : '') }}">{{ $errors->first('template_id') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'version', trans('admin/plan.form.label.version') ) !!}
            {!! Form::Text( 'version', Input::old('version'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('version') ? 'form-error' : '') }}">{{ $errors->first('version') }}</span>
        </div>
    </div>
    <div class="col-md-24 text-center">
        {!! Form::submit(trans('admin/plan.form.label.submit.' . $mode), array('class' => 'button btn btn-success')) !!}
        {!! HTML::link(URL::previous(), trans('form.label.cancel'), ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}

@stop