@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'admin.dashboard', 'Zurück zur Übersicht' ) }}</li>
        </ul>
    </li>
@stop

@section('headline')
    <h1>Admin: TUB-DMP</h1>
    <h3>Plans</h3>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            All Plans
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Project Number</th>
                            <th>Title</th>
                            <th>Version</th>
                            <th>Template</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $plans as $plan )
                            @include('partials.admin.plan.info', $plan)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! link_to_route('admin.plan.create', 'Create') !!}

@stop