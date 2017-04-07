@extends('layouts.bootstrap')

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Dashboard' ) !!}</li>
@stop

@section('headline')
    <!--<h1>Ihre Datenmanagementpläne</h1>-->
@stop

@section('body')

<div class="edit-project-without-modal panel panel-default">
    <div class="panel-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Project Metadata for {{ $project->identifier }}</h4>
    </div>
    <div id="edit-project-{{ $project->id }}">
        {!! BootForm::open()->class('edit-project-form-without-modal')->role('form')->data(['rel' => $project->id])->action( route('project.update') )->put() !!}
            <div class="panel-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Project Metadata for {{ $project->identifier }}</h4>
            </div>
            <div class="modal-body">
                <!-- PROJECT_ID -->
            {!! BootForm::hidden('id')->id('id')->value($project->id) !!}

            <!-- PROJECT TITLE -->
            {!! Form::metadata( $project, 'title' ) !!}

            <!-- PROJECT DURATION -->
                <label>{{ $project->getMetadataLabel('begin') }} / {{ $project->getMetadataLabel('end') }}:</label>
                <div class="form-group row">
                    <div class="col-md-6">
                        @if( $project->getMetadata('begin') )
                            {!! Form::date('begin[]', $project->getMetadata('begin')->first(), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::date('begin[]', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <div class="col-md-1">-</div>
                    <div class="col-md-6">
                        @if( $project->getMetadata('end') and $project->getMetadata('end')->count() )
                            {!! Form::date('end[]', $project->getMetadata('end')->first(), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::date('end[]', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                </div>

                <!-- PROJECT STAGE -->
            {!! Form::metadata( $project, 'stage' ) !!}

            <!-- PROJECT ABSTRACT -->
            {!! Form::metadata( $project, 'abstract' ) !!}

            <!-- PROJECT LEADER -->
            {!! Form::metadata( $project, 'leader' ) !!}

            <!-- PROJECT MEMBERS -->
            {!! Form::metadata( $project, 'member' ) !!}

            <!-- FUNDING SOURCE -->
            {!! Form::metadata( $project, 'funding_source' ) !!}

            <!-- FUNDING PROGRAM -->
            {!! Form::metadata( $project, 'funding_program' ) !!}

            <!-- GRANT REFERENCE NUMBER -->
            {!! Form::metadata( $project, 'grant_reference_number' ) !!}

            <!-- PROJECT MANAGEMENT ORGANISATION -->
            {!! Form::metadata( $project, 'project_management_organisation' ) !!}

            <!-- PROJECT DATA CONTACT -->
                {!! Form::metadata( $project, 'project_data_contact' ) !!}

            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Update')->class('btn btn-success') !!}
            </div>
        {!! BootForm::close() !!}
    </div>
</div>