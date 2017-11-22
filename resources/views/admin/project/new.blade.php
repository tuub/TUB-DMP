@extends('layouts.bootstrap')

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            New Project for {{ $user->email }}
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($project, ['method' => 'POST', 'route' => ['admin.project.store'], 'class' => '', 'role' => 'form']) !!}
                    {{ Form::hidden('user_id', $user->id) }}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'identifier', 'Project Number' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'identifier', Input::old('identifier'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('identifier') ? 'form-error' : '') }}">{{ $errors->first('identifier') }}</span>
                        </div>
                    </div>
                    <div class="row form-group container">
                        <div class="col-md-2">
                            {!! Form::Label( 'parent_id', 'Parent Project' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('parent_id', $projects, $project->parent_id, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('parent_id') ? 'form-error' : '') }}">{{ $errors->first('parent_id') }}</span>
                        </div>
                    </div>
                    <div class="row form-group container">
                        <div class="col-md-2">
                            {!! Form::Label( 'data_source_id', 'Data Source' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('data_source_id', $data_sources, $project->data_source_id, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('data_source_id') ? 'form-error' : '') }}">{{ $errors->first('data_source_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'contact_email', 'Institutional contact email' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'contact_email', Input::old('contact_email'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('contact_email') ? 'form-error' : '') }}">{{ $errors->first('contact_email') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            {!! Form::submit('Create', array('class' => 'button btn btn-success')) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop