<div class="row">
    <div class="col-md-12">
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
    </div>
    <div class="col-md-12">
        <span class="question-answer-text">
            @if( $question->input_type != 'headline')
                <?php
                $answers = App\Answer::getAnswer( $plan, $question );
                ?>
                {!! $answers !!}
            @endif
        </span>
    </div>
</div>
<br/>

@foreach($question->getChildren() as $question)
    @include('partials.question.show', $question)
@endforeach