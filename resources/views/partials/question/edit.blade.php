@if ($question->isChild())
    <div class="col-md-offset-{!! $question->getLevel() !!}">
@endif
<div class="row form-group">
    <div class="col-md-22 col-xs-22">
        <label for="{{ $question->id }}" class="question-text control-label">
            {% $question->getQuestionText() %}
        </label>

        @if($question->guidance)
            <div class="row">
                @infobox({% $question->guidance %})
            </div>
        @endif

        {!! Form::answer( $survey, $question ) !!}

    </div>
</div>

@if ($question->isChild())
    </div>
@endif

@foreach($question->getImmediateDescendants() as $question)
    @include('partials.question.edit', $question)
@endforeach