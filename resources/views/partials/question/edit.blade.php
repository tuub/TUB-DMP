@if ($question->isChild())
    <div class="col-md-offset-{!! $question->getLevel() !!}">
@endif
<div class="row form-group">
    <div class="col-md-22 col-xs-22">
        <label for="{{ $question->id }}" class="question-text control-label">
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