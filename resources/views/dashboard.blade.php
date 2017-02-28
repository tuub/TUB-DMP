@extends('layouts.bootstrap')

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Dashboard' ) !!}</li>
@stop

@section('headline')
    <!--<h1>Ihre Datenmanagementpläne</h1>-->
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            {{ trans('dashboard.my-plans-header') }}
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th style="width: 15%">Project-ID</th>
                            <th style="width: 5%;">Title</th>
                            <th style="width: 40%;">Members</th>
                            <th style="width: 40%;">Projects</th>
                            <th style="width: 40%;">Plans</th>
                            <th>Status</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            @include('partials.project.info', $project)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop