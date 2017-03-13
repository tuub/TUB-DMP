<div class="row form-group">
    <label for="{{ $question->id }}" class="control-label col-md-6 col-xs-24">
        <span class="question-text">
            @if( $question->input_type == 'headline')
                <span class="headline_question">
            @endif

            @if(is_numeric( $question->keynumber ) || str_contains($question->keynumber, '/'))
                {{ $question->keynumber }}.
            @else
                {{ $question->keynumber }}
            @endif

            {!! HTML::decode($question->text) !!}
            @if( $question->input_type == 'headline')
                </span>
            @endif
        </span>
        @if( $question->reference )
            <br/><span class="reference">{!! HTML::decode($question->reference) !!}</span>
        @endif
        @if( $question->comment )
            <br/>
            <span class="comment">{!! HTML::decode($question->comment) !!}</span>
        @endif
    </label>
    <div class="col-md-16 col-xs-24">
        @if( $question->guidance )
            <span class="help-block"><strong>Guidance:</strong> {!! HTML::decode($question->guidance) !!}</span>
        @endif
        {{-- Form::input_type_constructor( $plan, $question ) --}}
        @if( $question->hint )
            <span class="hint-block">
                <a href="#" class="expander" style="padding-left: 12px;">Click here for more information</a>
                <div class="content">
                    {!! HTML::decode($question->hint) !!}
                </div>
            </span>
        @endif
    </div>
    <div class="col-md-2 col-xs-24 text-md-left text-xs-left">
        <div class="question-status" id="{{ $question->id }}">
            <div class="saved">
                <span class="fa fa-check fa-2x" title="OK"></span>
            </div>
            <div class="unsaved">
                <a href="#" class="btn btn-default btn-xs ajaxsave" data-rel="{{ $question->id }}" title="Quicksave"><i class="unsaved fa fa-floppy-o fa-2x"></i><span class="hidden-xs"></span></a>
            </div>
            <div class="error">
                <span class="fa fa-exclamation fa-2x" title="Error"></span>
            </div>
        </div>
    </div>
</div>
@foreach($question->getChildren() as $question)
    @include('partials.question.edit', $question)
@endforeach