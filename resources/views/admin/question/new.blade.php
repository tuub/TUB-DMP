@extends('layouts.bootstrap')

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            New Question
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($question, ['method' => 'POST', 'route' => ['admin.question.store', $question->id], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'keynumber', 'Keynumber' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'keynumber', Input::old('keynumber'), array('class' => 'form-control xs') ) !!}
                            <span class="help-block {{ ($errors->first('keynumber') ? 'form-error' : '') }}">{{ $errors->first('keynumber') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'parent_question_id', 'Parent' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('parent_question_id', [null => 'None'] + $questions->toArray(), Input::old('question_parent_id'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('parent_question_id') ? 'form-error' : '') }}">{{ $errors->first('parent_question_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'text', 'Text' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Textarea( 'text', Input::old('text'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('text') ? 'form-error' : '') }}">{{ $errors->first('text') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'output_text', 'Output Text in PDF' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Textarea( 'output_text', Input::old('output_text'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('output_text') ? 'form-error' : '') }}">{{ $errors->first('output_text') }}</span>

                        </div>
                    </div>
                    <div class="form-group row container" id="vue-instance">
                        <div class="col-md-2">
                            {!! Form::Label( 'content_type_id', 'Content Type' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('content_type_id', $content_types->toArray(), 1, array('class' => 'form-control', 'v-model' => 'content_type',  'v-on:change' => 'showOptions')) !!}
                            <pre>@{{ $data | json }}</pre>
                            <span class="help-block {{ ($errors->first('content_type_id') ? 'form-error' : '') }}">{{ $errors->first('content_type_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'template_id', 'Template' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('template_id', $templates->toArray(), Input::old('template_id'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('template_id') ? 'form-error' : '') }}">{{ $errors->first('template_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'section_id', 'Section' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('section_id', [null => 'None'] + $sections->toArray(), Input::old('section_id'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('section_id') ? 'form-error' : '') }}">{{ $errors->first('section_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'value', 'Value' ) !!}
                        </div>
                        <div class="col-md-10">
                            @if( strlen( $question->value ) > 75 )
                                {!! Form::Textarea( 'value', Input::old('value'), array('class' => 'form-control') ) !!}
                            @else
                                {!! Form::Text( 'value', Input::old('value'), array('class' => 'form-control') ) !!}
                            @endif
                            <span class="help-block {{ ($errors->first('value') ? 'form-error' : '') }}">{{ $errors->first('value') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'default', 'Default' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'default', Input::old('default'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('default') ? 'form-error' : '') }}">{{ $errors->first('default') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'prepend', 'Prepend' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'prepend', Input::old('prepend'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('prepend') ? 'form-error' : '') }}">{{ $errors->first('prepend') }}</span>
                        </div>
                    </div>
                    @if( false )
                        <div class="form-group row container">
                            <div class="col-md-2">
                                {!! Form::Label( 'append', 'Append' ) !!}
                            </div>
                            <div class="col-md-10">
                                {!! Form::Text( 'append', Input::old('prepend'), array('class' => 'form-control') ) !!}
                                <span class="help-block {{ ($errors->first('append') ? 'form-error' : '') }}">{{ $errors->first('append') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'comment', 'Comment' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'comment', Input::old('comment'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('comment') ? 'form-error' : '') }}">{{ $errors->first('comment') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'reference', 'Reference' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'reference', Input::old('reference'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('reference') ? 'form-error' : '') }}">{{ $errors->first('reference') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'guidance', 'Guidance' ) !!}
                        </div>
                        <div class="col-md-10">
                            @if( strlen( $question->guidance ) > 75 )
                                {!! Form::Textarea( 'guidance', Input::old('guidance'), array('class' => 'form-control') ) !!}
                            @else
                                {!! Form::Text( 'guidance', Input::old('guidance'), array('class' => 'form-control') ) !!}
                            @endif
                            <span class="help-block {{ ($errors->first('guidance') ? 'form-error' : '') }}">{{ $errors->first('guidance') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'hint', 'Hint / More Information' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Textarea( 'hint', Input::old('hint'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('hint') ? 'form-error' : '') }}">{{ $errors->first('hint') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_mandatory', 'Mandatory' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_mandatory', 1, Input::old('is_mandatory')) !!} Yes
                            {!! Form::radio('is_mandatory', 0, Input::old('is_mandatory')) !!} No
                            <span class="help-block {{ ($errors->first('is_mandatory') ? 'form-error' : '') }}">{{ $errors->first('is_mandatory') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_active', 'Active' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_active', 1, Input::old('is_active')) !!} Yes
                            {!! Form::radio('is_active', 0, Input::old('is_active')) !!} No
                            <span class="help-block {{ ($errors->first('is_active') ? 'form-error' : '') }}">{{ $errors->first('is_active') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'read_only', 'Read Only' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('read_only', 1, Input::old('read_only')) !!} Yes
                            {!! Form::radio('read_only', 0, Input::old('read_only')) !!} No
                            <span class="help-block {{ ($errors->first('read_only') ? 'form-error' : '') }}">{{ $errors->first('read_only') }}</span>
                        </div>
                    </div>
                <div class="form-group row container">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class="col-md-10">
                        {!! Form::submit('Create', array('class' => 'button btn btn-success')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.min.js') !!}

    <script type="text/template" id="options-template">
        @foreach( $question->options as $option )
            {!! Form::Text( 'options', $option->text, array('class' => 'form-control') ) !!}
        @endforeach
    </script>

    <script>

        Vue.component('option', {
            props: ['foo'],
            template: "#options-template"
        });

        var vm = new Vue({
            el: '#vue-instance',
            data: {
                content_type: ''
            },
            methods: {
                showOptions: function() {
                    switch( this.content_type ) {
                        case '6':
                            console.log( 'Case for Option Area' );
                            break;
                        case '7':
                            console.log( 'Case for Option Area' );
                            break;
                        default:
                            console.log( 'Naah!' );
                            break;
                    }
                },
                addOption: function() {
                    e.preventDefault();

                }

            }
        });
    </script>


@stop