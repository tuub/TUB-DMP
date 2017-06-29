@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Übersicht' ) }}</li>
@stop

@section('headline')
    <h1 class="page-header">Admin</h1>
@stop

@section('body')

        <div class="row text-center">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Templates</h3>
                        <p class="card-text">Change templates.</p>
                        {{ HTML::link(route('admin.template.index'), 'Edit Templates', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Sections</h3>
                        <p class="card-text">Change sections.</p>
                        {{ HTML::link(route('admin.section.index'), 'Edit Sections', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Questions</h3>
                        <p class="card-text">Change questions.</p>
                        {{ HTML::link(route('admin.question.index'), 'Edit Questions', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Users</h3>
                        <p class="card-text">Change users.</p>
                        {{ HTML::link(route('admin.user.index'), 'Edit Users', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Projects</h3>
                        <p class="card-text">Change projects.</p>
                        {{ HTML::link(route('admin.project.index'), 'Edit Projects', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Plans</h3>
                        <p class="card-text">Change plans.</p>
                        {{ HTML::link(route('admin.plan.index'), 'Edit Plans', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">System Info</h3>
                        <p class="card-text">View PHP Info.</p>
                        {{ HTML::link(route('admin.phpinfo'), 'PHP Info', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Lookup</h3>
                        <p class="card-text">Lookup project identifier.</p>
                        {{ HTML::link(route('admin.project.get_lookup'), 'Lookup', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Logs</h3>
                        <p class="card-text">View the logfile.</p>
                        {{ HTML::link(route('admin.log_viewer'), 'Log Viewer', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-block">
                        <h3 class="card-title">Random</h3>
                        <p class="card-text">Random external project identifiers.</p>
                        {{ HTML::link(route('admin.random_ivmc'), 'Random IVMC', ['class' => 'btn btn-default']) }}
                    </div>
                </div>
            </div>
        </div>

@stop