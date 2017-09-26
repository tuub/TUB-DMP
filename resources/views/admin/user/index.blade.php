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
    <h3>Users</h3>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            All Users
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>TUB OM</th>
                        <th>Email</th>
                        <th>Plans</th>
                        <th>Admin</th>
                        <th>Active</th>
                        <th>Last Login</th>
                        <th>Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $users as $user )
                        @include('admin.partials.user.info', $user)
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop