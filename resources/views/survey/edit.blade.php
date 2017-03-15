@extends('layouts.bootstrap')

@section('header_assets')
    @parent
    {!! HTML::script('js/plan.js') !!}
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

    <script>
        $(document).ready(function(){
            $("#plan-section-steps").steps({
                headerTag: "h4",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                enableAllSteps: true,
                saveState: true,
                enablePagination: false,
                titleTemplate: '#title#',
                stepsOrientation: 1,
                transitionEffectSpeed: 100,
                onStepChanging: function (event, currentIndex, newIndex) {
                    if($(window).scrollTop() > 0) {
                        $('html, body').animate({
                            scrollTop:0
                        }, 300);
                    }
                    return true;
                },
            });
        })
    </script>

    {!! Form::open(array('route' => array('survey.update'), 'method' => 'put', 'class' => 'form-horizontal', 'id' => 'save_plan'))  !!}

    <div>
        <div class="progress col-md-20 col-sm-24 nopadding">
            <div class="progress-bar" role="progressbar" data-transitiongoal="{{ $survey->getQuestionAnswerPercentage() }}"></div>
        </div>
        <div class=" col-md-4 col-sm-24 nopadding">
            {!! Form::button('<i class="fa fa-floppy-o"></i><span class="hidden-xs"> Plan speichern</span>', array('type' => 'submit', 'name' => 'save', 'class' => 'btn btn-success pull-right', 'style' => 'font-size: 17px')) !!}
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

                @foreach( $section->questions()->active()->get() as $question )
                    @if( $question->isRoot() )
                        @include('partials.question.edit', $question)
                    @endif
                @endforeach
            </section>
        @endforeach

    </div>
    {!! Form::close() !!}
@stop