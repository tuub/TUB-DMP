@extends('layouts.bootstrap')

@section('header_assets')
    @parent
    {!! HTML::script('js/plan.js') !!}
@append

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Back to Dashboard' ) !!}</li>
@append

@section('headline')
    <h3>Data Management Plan for TUB Project {{ $survey->plan->project->identifier }}</h3>
    <h4>Version: {{ $survey->plan->version }}</h4>
@stop

@section('body')
        <ol id="plan-toc">
            @foreach( $survey->template->sections()->active()->get() as $section )
                <li><a href="#{{ $section->keynumber }}">{{ $section->name }}</a></li>
            @endforeach
        </ol>

        @foreach( $survey->template->sections()->active()->get() as $section )
            <div class="col-md-24">
                <h3>
                    <a class="anchor" name="{{ $section->keynumber }}"></a>
                    {{ $section->full_name }}
                </h3>
                <div class="section-text">
                    @foreach( $section->questions()->active()->parent()->get() as $question )
                        @include('partials.question.show', $question)
                    @endforeach
                </div>
            </div>
        @endforeach
@stop