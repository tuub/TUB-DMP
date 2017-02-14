@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'admin', 'Zurück zur Übersicht' ) }}</li>
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

    @if( Auth::user()->is_admin )
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                Create New Plan
            </div>
            <div class="panel-body">
                {!! Form::model($plan, ['method' => 'POST', 'route' => ['admin.plan.store', $plan->id], 'class' => '', 'role' => 'form']) !!}
                <div class="form-group row">
                    <div class="col-md-2">
                        {!! Form::label('project_number', 'Your Projekt Number', array('class' => 'control-label')) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::text('project_number', '', array('class' => 'form-control')) !!}
                        <span class="help-block {{ ($errors->first('project_number') ? 'form-error' : '') }}">{{ $errors->first('project_number') }}</span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {!! Form::label('version', 'DMP Version', array('class' => 'control-label')) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::select('version', [null => 'None'] + $versions, 1, array('class' => 'form-control') ) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {!! Form::label('template_id', 'Plan Template', array('class' => 'control-label')) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::select('template_id', [null => 'None'] + $templates->toArray(), 3, array('class' => 'form-control') ) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {!! Form::label('datasource', 'Datasource', array('class' => 'control-label')) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::select('datasource', [null => 'None'] + $datasources, null, array('class' => 'form-control') ) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {!! Form::label('user_id', 'Plan Owner', array('class' => 'control-label')) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::select('user_id', [null => 'None'] + $users->toArray(), 1, array('class' => 'form-control') ) !!}
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
    @endif





@stop