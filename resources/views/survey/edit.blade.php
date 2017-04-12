@extends('layouts.bootstrap')

@section('header_assets')
    @parent
    {!! HTML::script('js/survey.js') !!}
@append

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Back to Dashboard' ) !!}</li>
@append

@section('headline')
    <h2>Data Management Plan for TUB Project {{ $survey->plan->project->identifier }}</h2>
@stop

@section('body')

    <style>
        * {
            outline: 0px #336699 solid;
        }

        #plan-section-steps h4 {
            margin-top: 0 !important;
        }

    </style>

    {!! Form::open(['route' => ['survey.update', $survey->id], 'method' => 'put', 'class' => 'form-horizontal', 'id' => 'save_plan'])  !!}

    <div>
        <div class="progress col-md-20 col-sm-24 nopadding">
            <div class="progress-bar" role="progressbar" data-transitiongoal="{{ $survey->completion }}"></div>
        </div>
        <div class=" col-md-4 col-sm-24 nopadding">
            {!! Form::button('<i class="fa fa-floppy-o"></i><span class="hidden-xs"> Plan speichern</span>', ['type' => 'submit', 'name' => 'save', 'class' => 'btn btn-success pull-right', 'style' => 'font-size: 17px']) !!}
        </div>
    </div>
    <br/><br/><br/>
    <div id="plan-section-steps">

        @foreach( $survey->template->sections()->active()->get() as $section )
            <h4 style="font-weight: bold;">
                {{ $section->full_name }}
            </h4>
            <section id="section-{{ $section->keynumber }}">
                <h4 style="font-weight: bold;">
                    {{ $section->full_name }}
                </h4>
                @if( $section->guidance )
                    <span class="help-block">
                        <strong>Guidance:</strong>
                        {{ $section->guidance }}
                    </span>
                @endif

                @foreach( $section->questions()->active()->ordered()->get() as $question )
                    @if( $question->isRoot() )
                        @include('partials.question.edit', $question)
                    @endif
                @endforeach
            </section>
        @endforeach

    </div>
    {!! Form::close() !!}
@stop