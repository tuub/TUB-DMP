@extends('layouts.bootstrap')

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            New Project
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($project, ['method' => 'POST', 'route' => ['admin.project.store'], 'class' => '', 'role' => 'form']) !!}
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
                            {!! Form::Label( 'user_id', 'Owner' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('user_id', $users, $project->user_id, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('user_id') ? 'form-error' : '') }}">{{ $errors->first('user_id') }}</span>
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