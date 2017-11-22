@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('sections', $template) }}

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Sections of Template "{{ $template->name }}"
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed sortable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Questions</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th data-orderable="false">Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach( $sections as $section )
                            @include('admin.partials.section.info', $section)
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! link_to_route('admin.template.sections.create', 'Create', ['template' => $template]) !!}
            </div>
        </div>
    </div>
@stop