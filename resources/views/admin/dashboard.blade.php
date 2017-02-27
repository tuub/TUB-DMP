@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Übersicht' ) }}</li>
@stop

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('body')

    <h3>Edit Data</h3>

    {!! link_to_route('admin.template.index', 'Templates') !!}<br/>
    {!! link_to_route('admin.section.index', 'Sections') !!}<br/>
    {!! link_to_route('admin.question.index', 'Questions') !!}<br/>

    {!! link_to_route('admin.project.index', 'Projects') !!}<br/>
    {!! link_to_route('admin.plan.index', 'Plans') !!}<br/>
    {!! link_to_route('admin.user.index', 'Users') !!}<br/>

    <hr/>
    {!! link_to_route('admin.phpinfo', 'PHP Info') !!}<br/>
    {!! link_to_route('admin.random_ivmc', 'Random IVMC') !!}<br/>
    {!! link_to_route('admin.log_viewer', 'Log Viewer') !!}<br/>

@stop