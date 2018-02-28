@if ($question->isChild())
    <div class="col-md-offset-{!! $question->getLevel() !!}">
@endif
<div class="row form-group">
    <div class="col-md-22 col-xs-22">
        @if( $question->content_type->identifier === 'plain')
            <div for="{{ $question->id }}" class="question-text headline-text control-label">
        @else
            <label for="{{ $question->id }}" class="question-text control-label">
        @endif

        @if(is_numeric( $question->keynumber ) || str_contains($question->keynumber, '/'))
            {{ $question->keynumber }}.
        @else
            {{ $question->keynumber }}
        @endif

            {!! HTML::decode($question->text) !!}

        </label>

        @if($question->guidance)
            <div class="guidance">
                <strong>Guidance: </strong>
                {!! HTML::decode($question->guidance) !!}
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