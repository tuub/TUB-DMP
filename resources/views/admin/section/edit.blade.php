@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($section, 'admin.section.form', [
        'section' => $section,
        'template' => $section->template,
        'mode' => 'edit',
        'action' => 'update',
        'method' => 'PUT',
    ])

@stop
