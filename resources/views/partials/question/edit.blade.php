@if ($question->isChild())
    <div class="col-md-offset-1">
@endif
<div class="row form-group">
    @if( $question->content_type->identifier == 'plain')
        <label for="{{ $question->id }}" class="question-text headline-text control-label col-md-24 col-xs-24">
    @else
        <label for="{{ $question->id }}" class="question-text control-label col-md-6 col-xs-24">
    @endif
        @if(is_numeric( $question->keynumber ) || str_contains($question->keynumber, '/'))
            {{ $question->keynumber }}.
        @else
            {{ $question->keynumber }}
        @endif

        {!! HTML::decode($question->text) !!}

        @if( $question->guidance or $question->comment or $question->reference or $question->hint )
            <br/>
            <a href="#" class="show-question-info" data-rel="{{  $question->id }}"
               data-toggle="modal" data-target="#show-question-info-{{ $question->id }}" title="Show Question Info">
               <i class="fa fa fa-info-circle " aria-hidden="true"></i>
               More Info
            </a>
            @include('partials.question.modal', $question)
        @endif
    </label>
    <div class="col-md-16 col-xs-24">
        {!! Form::answer( $survey, $question ) !!}
    </div>
    <div class="col-md-2 col-xs-24 text-md-left text-xs-left">
        <div class="question-status" id="{{ $question->id }}">
            <div class="saved">
                <span class="fa fa-check fa-2x" title="OK"></span>
            </div>
            <div class="unsaved">
                <span class="fa fa-exclamation fa-2x" title="Unsaved"></span>
            </div>
            <div class="error">
                <span class="fa fa-exclamation fa-2x" title="Error"></span>
            </div>
        </div>
    </div>
</div>
@if ($question->isChild())
    </div>
@endif

@foreach($question->getImmediateDescendants() as $question)
    @include('partials.question.edit', $question)
@endforeach