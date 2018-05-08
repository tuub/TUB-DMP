@php
    $answer = \App\Answer::get($survey, $question, 'html');
@endphp

@if(($question->export_always === true
    || $answer !== null)
    || ($question->content_type->identifier === 'plain'
        && $question->getImmediateDescendants()->count() > 0
        && $question->childrenHaveAnswers($survey)
        && $question->export_never === false
    ))
    <div class="row question">
        @if ($question->content_type->identifier === 'plain' || $question->isChild())
            <div style="padding-left:{!! ($question->getLevel()+1*0.4) !!}em">
        @endif
        <strong>
            @if($question->export_keynumber)
                {{ $question->keynumber }}
            @endif
            @if($question->output_text === null)
                {{ $question->text }}
            @else
                {{ $question->output_text }}
            @endif
        </strong>

        <br/>
        {!! $answer  !!}

        @if ($question->isChild())
            </div>
        @endif
    </div>
    <br/>
@endif

@foreach($question->getImmediateDescendants() as $question)
    @include('partials.question.pdf', [$survey, $question])
@endforeach