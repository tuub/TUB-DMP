@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($project, 'admin.project.form', [
        'project' => $project,
        'user' => $project->user,
        'mode' => 'edit',
        'action' => 'update',
        'method' => 'PUT',
    ])

@stop
