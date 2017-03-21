{{ $question->prepend }}

{{ var_dump($answers) }}

@if( false )
    @if( $answers->count() )
        @foreach( $answers as $answer )
            {{ Form::text( $name . '[]', $answer, [
                'data-type' => 'list',
                'data-role' => 'tagsinput',
                'class' => 'question form-control tagsinput',
                'title' => $question->output_text,
                $read_only
            ]) }}
        @endforeach
    @else
        {{ Form::text( $name . '[]', null, [
                'data-type' => 'list',
                'data-role' => 'tagsinput',
                'class' => 'question form-control tagsinput',
                'title' => $question->output_text,
                $read_only
            ]) }}
    @endif
@endif
{{ $question->append }}