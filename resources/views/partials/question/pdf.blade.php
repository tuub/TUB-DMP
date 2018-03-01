@php
    $answer = \App\Answer::get($survey, $question, 'html');
@endphp

@unless($question->export_always === false && null === $answer)
    <div class="row question">
        @if ($question->isChild())
            <div style="padding-left:{!! ($question->getLevel()+1*0.4) !!}em">
        @endif
        <strong>
            @if($question->export_keynumber)
                {{ $question->keynumber }}
            @endif
            @if(null === $question->output_text)
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
@endunless

@foreach($question->getImmediateDescendants() as $question)
    @include('partials.question.pdf', [$survey, $question])
@endforeach