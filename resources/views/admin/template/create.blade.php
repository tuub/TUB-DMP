@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($template, 'admin.template.form', [
        'template' => $template,
        'mode' => 'create',
        'action' => 'store',
        'method' => 'POST',
    ])

@stop