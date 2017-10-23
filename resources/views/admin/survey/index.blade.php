@extends('layouts.bootstrap')

@section('navigation')
@stop

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('survey', $plan) }}

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Survey of Plan "{{ $plan->title }}"
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-fixed data-table">
                    <thead>
                    <tr>
                        <th class="col-md-11">Question</th>
                        <th class="col-md-11">Answer</th>
                        <th class="col-md-2" data-orderable="false">Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $survey as $question => $answer )
                        @include('admin.partials.survey.info', ['question' => $question, 'answer' => $answer])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop