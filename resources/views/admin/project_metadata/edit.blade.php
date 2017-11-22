@extends('layouts.bootstrap')

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')
    Metadata for {{ $project->identifier }}
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit Metadata for "{{ $project->identifier }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($project_metadata, ['method' => 'PUT', 'route' => ['admin.project_metadata.update', $project_metadata->id], 'class' => '', 'role' => 'form']) !!}
                <div class="form-group row container">
                    <div class="col-md-2">
                        {!! Form::Label( 'identifier', 'Project Number' ) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::Text( 'identifier', $project->identifier, array('class' => 'form-control') ) !!}
                        <span class="help-block {{ ($errors->first('identifier') ? 'form-error' : '') }}">{{ $errors->first('identifier') }}</span>
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