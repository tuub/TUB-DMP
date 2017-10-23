@extends('layouts.bootstrap')

@section('navigation')
@stop

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('plans', $project) }}

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Plans for {{ $project->identifier }}
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed data-table">
                    <thead>
                        <tr>
                            <th class="col-md-4">Title</th>
                            <th class="col-md-3">Version</th>
                            <th class="col-md-3">Template</th>
                            <th class="col-md-1">Status</th>
                            <th class="col-md-1">Snapshot</th>
                            <th class="col-md-4">Created</th>
                            <th class="col-md-4">Updated</th>
                            <th class="col-md-4" data-orderable="false">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $plans as $plan )
                            @include('admin.partials.plan.info', $plan)
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! link_to_route('admin.project.plans.create', 'Create', ['project' => $project]) !!}
            </div>
        </div>
    </div>
@stop