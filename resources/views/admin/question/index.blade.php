@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('questions', $section) }}

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Questions for section "{{ $section->name }}"
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed sortable">
                    <thead>
                        <tr>
                            <th>Text</th>
                            <th class="text-center">Guidance</th>
                            <th class="text-center">Default</th>
                            <th class="text-center">Answers</th>
                            <th>Created</th>
                            <th data-orderable="false">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $questions as $question )
                            @include('admin.partials.question.info', $question)
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! link_to_route('admin.question.create', 'Create', ['section' => $section]) !!}
            </div>
        </div>
    </div>
@stop