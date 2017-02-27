@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'admin.dashboard', 'Zurück zur Übersicht' ) }}</li>
        </ul>
    </li>
@stop

@section('headline')
    <h1>Admin: TUB-DMP</h1>
    <h3>New plan</h3>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Create New Plan
        </div>
        <div class="panel-body">
            {!! Form::model($plan, ['method' => 'POST', 'route' => ['admin.plan.store'], 'class' => '', 'role' => 'form']) !!}
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
                    {!! Form::label('project_id', 'Project', array('class' => 'control-label')) !!}
                </div>
                <div class="col-md-10">
                    {!! Form::select('project_id', $projects, null, array('class' => 'form-control') ) !!}
                    <span class="help-block {{ ($errors->first('project_id') ? 'form-error' : '') }}">{{ $errors->first('project_id') }}</span>
                </div>
            </div>
            <div class="row form-group container">
                <div class="col-md-2">
                    {!! Form::label('version', 'DMP Version', array('class' => 'control-label')) !!}
                </div>
                <div class="col-md-10">
                    {!! Form::select('version', $versions, 1, array('class' => 'form-control') ) !!}
                    <span class="help-block {{ ($errors->first('version') ? 'form-error' : '') }}">{{ $errors->first('version') }}</span>
                </div>
            </div>
            <div class="row form-group container">
                <div class="col-md-2">
                    {!! Form::label('template_id', 'Plan Template', array('class' => 'control-label')) !!}
                </div>
                <div class="col-md-10">
                    {!! Form::select('template_id', $templates, null, array('class' => 'form-control') ) !!}
                    <span class="help-block {{ ($errors->first('template_id') ? 'form-error' : '') }}">{{ $errors->first('template_id') }}</span>
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