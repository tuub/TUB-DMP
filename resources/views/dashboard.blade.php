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
                            <th style="width: 15%">TUB Project</th>
                            <th style="width: 5%;">Version</th>
                            <th style="width: 40%;">Details</th>
                            <th style="width: 40%;">Tools</th>
                            @if( false )
                                <th>Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                            @include('partials.plan.info', $plan)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop