@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')

@stop

@section('body')

    {{ Breadcrumbs::render('projects', $user) }}

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Projects of {{ $user->email ? $user->email : trans('admin/table.value.null') }}
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed data-table">
                    <thead>
                    <tr>
                        <th>Identifier</th>
                        <th>Contact Email</th>
                        <th>Plans</th>
                        <th>Import</th>
                        <th>Updated</th>
                        <th data-orderable="false">Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach( $projects as $project )
                            @include('admin.partials.project.info', $project)
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! link_to_route('admin.user.projects.create', 'Create', ['user' => $user]) !!}
            </div>
        </div>
    </div>
@stop