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
                            <th data-orderable="false">#</th>
                            <th>Keynumber</th>
                            <th>Text</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th data-orderable="false">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $questions as $question )
                            @if (true)
                                @include('admin.partials.question.info', $question)
                            @endif
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