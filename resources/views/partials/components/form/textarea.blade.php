{{ $question->prepend }}

@if( $answers->count() )
    @foreach( $answers as $answer )
        {{ Form::Textarea( $name . '[]', null, [
            'data-type' => 'text',
            'rows' => 6,
            'class' => 'question form-control',
            'title' => $question->output_text,
            $read_only
        ]) }}
    @endforeach
@else
    {{ Form::Textarea( $name . '[]', null, [
        'data-type' => 'text',
        'rows' => 2,
        'class' => 'question form-control',
        'title' => $question->output_text,
        $read_only
    ]) }}
@endif

{{ $question->append }}