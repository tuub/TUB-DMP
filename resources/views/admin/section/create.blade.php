@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($section, 'admin.section.form', [
        'section' => $section,
        //'template' => $project,
        'mode' => 'create',
        'action' => 'store',
        'method' => 'POST',
    ])

@stop