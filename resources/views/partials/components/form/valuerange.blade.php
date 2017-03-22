<script>
    $(document).ready(function(){
        $(".slider").bootstrapSlider({});

        $(".slider-enabled").click(function() {
            if(this.checked) {
                // With JQuery
                $("#ex2").bootstrapSlider("enable");
            }
            else {
                // With JQuery
                $("#ex2").bootstrapSlider("disable");
            }
        });
    })
</script>

{{ $question->prepend }}

@if( $answers->count() )

        @{{ Form::text( $name . '[]', null, [
                'data-type' => 'valuerange',
                'data-slider-min' => '0',
                'data-slider-max' => '10000',
                'data-slider-step' => '25',
                'data-slider-value' => '[' . $answers['alpha'] . ',' . $answers['omega'] . ']',
                'class' => 'question slider',
                'title' => $question->output_text,
                $read_only
            ]) }}

        <input class="slider-enabled" type="checkbox"/> Enabled

@endif

@if( false )
    @if( $answers->count() )
        @foreach( $answers as $label => $value )
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