@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($project, 'admin.project.form', [
        'project' => $project,
        //'template' => $project,
        'mode' => 'create',
        'action' => 'store',
        'method' => 'POST',
    ])

@stop