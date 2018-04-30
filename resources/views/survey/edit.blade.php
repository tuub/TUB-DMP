@extends('layouts.bootstrap')

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

        @foreach( $survey->template->sections()->active()->ordered()->get() as $section )
            <div class="section-title">
                {{ $section->full_name }}
            </div>
            <section id="section-{{ $section->keynumber }}">
                <div class="section-title">
                    {{ $section->full_name }}
                </div>
                @if( $section->guidance )
                    <div class="guidance">
                        <strong>Guidance: </strong>
                        {!! HTML::decode($section->guidance) !!}
                    </div>
                @endif

                @foreach(\App\Question::roots()->active()->where('section_id', $section->id)->orderBy('order', 'asc')->get() as $question)
                    @include('partials.question.edit', $question)
                @endforeach
            </section>
        @endforeach
    </div>
    {!! Form::close() !!}
@stop