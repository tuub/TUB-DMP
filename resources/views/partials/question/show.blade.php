@if ($question->isChild())
    <div class="col-md-offset-{!! $question->getLevel() !!}">
@endif

<div class="row">
    <div class="col-md-24">
        <span class="question-text">
            @if($question->content_type->identifier === 'plain')
                <span class="headline_question">
            @endif

            {% $question->getQuestionText() %}

            @if($question->content_type->identifier === 'plain')
                </span>
            @endif
        </span>
    </div>

    @if($question->content_type->identifier !== 'plain')
        <div class="col-md-24">
            <div style="display: inline-block; margin-top: 10px; margin-left: 18px;">
                <div class="question-answer-text">
                    {!! App\Answer::get($survey, $question, 'html') !!}
                </div>
            </div>
        </div>
    @endif
</div>
<br/>
@if ($question->isChild())
    </div>
@endif

@foreach($question->getImmediateDescendants() as $question)
    @include('partials.question.show', $question)
@endforeach