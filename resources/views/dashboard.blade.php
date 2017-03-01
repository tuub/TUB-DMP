@extends('layouts.bootstrap')

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Dashboard' ) !!}</li>
@stop

@section('headline')
    <!--<h1>Ihre Datenmanagementpläne</h1>-->
@stop

@section('body')

    <style>
        div.dashboard-plan-info {
            margin-left: 2%;
            font-style: italic;
        }

        div.dashboard-plan-info td {
            padding: 15px 15px 5px 0px !important;
        }

        div.dashboard-plan-info td.title {
            font-weight: bold;
            vertical-align: top;
            text-transform: uppercase;
        }

        div.dashboard-plan-info td.metadata {
            vertical-align: top;
        }

        div.dashboard-plan-info td.timestamps {
            vertical-align: top;
        }

        div.dashboard-plan-info td.status {
            font-weight: bold;
            font-size: 2em;
        }

        div.dashboard-plan-info td.tools {
            font-weight: bold;
            font-size: 2em;
        }

    </style>

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            {{ trans('dashboard.my-plans-header') }}
        </div>
        <div class="panel-body">
            <div class="table-responsive" id="my-plans">
                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th style="width: 15%">Project</th>
                            <th style="width: 25%">Metadata</th>
                            <th style="width: 20%;">Owners</th>
                            <th style="width: 5%;">Plans</th>
                            <th style="width: 5%;">Projects</th>
                            <th style="width: 15%;">Data Source</th>
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