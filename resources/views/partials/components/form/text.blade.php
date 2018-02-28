{{ $question->prepend }}

@if( $answers->count() )
    @foreach( $answers as $answer )
        {{ Form::text( $name . '[]', $answer, [
            'data-type' => 'text',
            'class' => 'question form-control',
            'title' => $question->output_text,
            $read_only
        ]) }}
    @endforeach
@else
    {{ Form::text( $name . '[]', null, [
            'data-type' => 'text',
            'class' => 'question form-control',
            'title' => $question->output_text,
            'placeholder' => $question->comment,
            $read_only
        ]) }}
@endif

{{ $question->append }}