@extends('layouts.bootstrap')

@section('headline')
    <h1>Admin: TUB-DMP</h1>
    <h3>New plan</h3>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Create New Plan in {{ $project->identifier }}
        </div>
        <div class="panel-body">
            {!! Form::model($plan, ['method' => 'POST', 'route' => ['admin.plan.store'], 'class' => '', 'role' => 'form']) !!}
            {{ Form::hidden('project_id', $project->id) }}
            <div class="form-group row container">
                <div class="col-md-2">
                    {!! Form::Label( 'title', 'Title' ) !!}
                </div>
                <div class="col-md-10">
                    {!! Form::Text( 'title', $plan->title, array('class' => 'form-control xs') ) !!}
                    <span class="help-block {{ ($errors->first('title') ? 'form-error' : '') }}">{{ $errors->first('title') }}</span>
                </div>
            </div>
            <div class="row form-group container">
                <div class="col-md-2">
                    {!! Form::label('template_id', 'Template', array('class' => 'control-label')) !!}
                </div>
                <div class="col-md-10">
                    {!! Form::select('template_id', $templates, null, array('class' => 'form-control') ) !!}
                    <span class="help-block {{ ($errors->first('template_id') ? 'form-error' : '') }}">{{ $errors->first('template_id') }}</span>
                </div>
            </div>

            <div class="row form-group container">
                <div class="col-md-2">
                    {!! Form::label('version', 'DMP Version', array('class' => 'control-label')) !!}
                </div>
                <div class="col-md-10">
                    {!! Form::Text( 'version', $plan->version, array('class' => 'form-control xs') ) !!}
                    <span class="help-block {{ ($errors->first('version') ? 'form-error' : '') }}">{{ $errors->first('version') }}</span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-offset-4 col-md-8">
                    {!! Form::submit('Create', array('class' => 'button btn btn-success' )) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop