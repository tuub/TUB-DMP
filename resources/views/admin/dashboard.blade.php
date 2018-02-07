@extends('layouts.bootstrap')

@section('headline')

@stop

@section('body')

    {{ Breadcrumbs::render('admin') }}

    <h2>To-Do</h2>
    @include('admin.partials.project.pending_index', $projects)

    <h2>Data Management</h2>
    @include('admin.partials.template.index', $templates)

    <h2>Users</h2>
    @include('admin.partials.user.index')

    @if (env('APP_SERVER') !== 'demo')
        <h2>Helpers</h2>
        {{ HTML::link(route('admin.project.get_lookup'), 'Lookup', ['class' => 'btn btn-default']) }}
        {{ HTML::link(route('admin.random_ivmc'), 'Random IVMC', ['class' => 'btn btn-default']) }}
    @endif

    <h2>Data Sources</h2>
    @include('admin.partials.data_source.index')
    - Mappings

    @if (env('APP_SERVER') !== 'demo')
        <h2>System</h2>
        {{ HTML::link(route('admin.phpinfo'), 'PHP Info', ['class' => 'btn btn-default']) }}
        {{ HTML::link(route('admin.log_viewer'), 'Log Viewer', ['class' => 'btn btn-default']) }}
    @endif
@stop