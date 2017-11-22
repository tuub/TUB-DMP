@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit Plan "{{ $plan->title }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($plan, ['method' => 'PUT', 'route' => ['admin.plan.update', $plan->id], 'class' => '', 'role' => 'form']) !!}
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
                            {!! Form::select('project_id', $projects, $plan->project_id, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('project_id') ? 'form-error' : '') }}">{{ $errors->first('project_id') }}</span>
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