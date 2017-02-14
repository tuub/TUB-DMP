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
@stop

@section('title')
    {{ $plan->project_number }} / {{ $plan->version }}
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit Plan "{{ $plan->project_number }} / {{ $plan->version }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($plan, ['method' => 'PUT', 'route' => ['admin.plan.update', $plan->id], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'project_number', 'Project Number' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'project_number', $plan->project_number, array('class' => 'form-control xs') ) !!}
                            <span class="help-block {{ ($errors->first('project_number') ? 'form-error' : '') }}">{{ $errors->first('project_number') }}</span>
                        </div>
                    </div>
                    <div class="row form-group container">
                        <div class="col-md-2">
                            {!! Form::label('version', 'DMP Version', array('class' => 'control-label')) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('version', [null => 'None'] + $versions, $plan->version, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('version') ? 'form-error' : '') }}">{{ $errors->first('version') }}</span>
                        </div>
                    </div>
                    <div class="row form-group container">
                        <div class="col-md-2">
                            {!! Form::label('template_id', 'Plan Template', array('class' => 'control-label')) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('template_id', [null => 'None'] + $templates->toArray(), $plan->template_id, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('template_id') ? 'form-error' : '') }}">{{ $errors->first('template_id') }}</span>
                        </div>
                    </div>
                    <div class="row form-group container">
                        <div class="col-md-2">
                            {!! Form::label('datasource', 'Datasource', array('class' => 'control-label')) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('datasource', [null => 'None'] + $datasources, $plan->datasource, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('datasource') ? 'form-error' : '') }}">{{ $errors->first('datasource') }}</span>
                        </div>
                    </div>
                    <div class="row form-group container">
                        <div class="col-md-2">
                            {!! Form::label('user_id', 'Plan Owner', array('class' => 'control-label')) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('user_id', [null => 'None'] + $users->toArray(), $plan->user_id, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('user_id') ? 'form-error' : '') }}">{{ $errors->first('user_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            {!! Form::submit('Update', array('class' => 'button btn btn-success')) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop