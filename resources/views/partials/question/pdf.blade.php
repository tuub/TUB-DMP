@php
    $answer = \App\Answer::get($survey, $question, 'html');
@endphp

@if ($question->display($survey, $question, false))
    <div class="row question">
        @if ($question->content_type->identifier === 'plain' || $question->isChild())
            <div style="padding-left:{!! ($question->getLevel()+1*0.4) !!}em">
        @endif
        <strong>
            @if($question->export_keynumber)
                @if(is_numeric($question->keynumber))
                    @if($question->output_text)
                        {% $question->keynumber . '.&nbsp;' . $question->output_text %}
                    @else
                        {% $question->keynumber . '.&nbsp;' . $question->text %}
                    @endif
                @else
                    @if($question->output_text)
                        {% $question->keynumber . '&nbsp;' . $question->output_text %}
                    @else
                        {% $question->keynumber . '&nbsp;' . $question->text %}
                    @endif
                @endif
            @else
                @if($question->output_text)
                    {% $question->output_text %}
                @else
                    {% $question->text %}
                @endif
            @endif
        </strong>
        {!! $answer !!}

        @if ($question->isChild())
            </div>
        @endif
    </div>
@endif

@foreach($question->getImmediateDescendants() as $question)
    @include('partials.question.pdf', [$survey, $question])
@endforeach