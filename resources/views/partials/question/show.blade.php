<div class="row">
    <div class="col-md-24">
        <span class="question-text">
            @if( $question->input_type == 'headline')
                <span class="headline_question">
            @endif

            @if(is_numeric( $question->keynumber ) || str_contains($question->keynumber, '/'))
                {{ $question->keynumber }}.
            @else
                {{ $question->keynumber }}
            @endif

            @if( $question->output_text )
                {{ $question->output_text }}
            @else
                {{ $question->text }}
            @endif
            @if( $question->input_type == 'headline')
                </span>
            @endif
        </span>
    </div>
    <div class="col-md-24">
        <span class="question-answer-text">
            @if( $question->input_type != 'headline')
                {!! App\Answer::get( $survey, $question, 'html' ) !!}
                <?php
                //$answers = App\Answer::getAnswer( $plan, $question );
                ?>
            @endif
        </span>
    </div>
</div>
<br/>

@foreach($question->getChildren() as $question)
    @include('partials.question.show', $question)
@endforeach