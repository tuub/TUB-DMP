@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'dashboard', 'Zurück zur Übersicht' ) }}</li>
        </ul>
    </li>
@stop

@section('headline')
    <h1>Edit Project</h1>
@stop

@section('title')
    {{ $project->identifier }}
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit Project "{{ $project->identifier }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::open(['method' => 'PUT', 'route' => ['project.update', $project->id], 'class' => '', 'role' => 'form']) !!}

                @foreach( $metadata_fields as $metadata_field )
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( $metadata_field->identifier, $metadata_field->name ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( $metadata_field->identifier, $project->title, array('class' => 'form-control xs') ) !!}
                            <span class="help-block {{ ($errors->first($metadata_field->identifier) ? 'form-error' : '') }}">{{ $errors->first($metadata_field->identifier) }}</span>
                        </div>
                    </div>
                @endforeach
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