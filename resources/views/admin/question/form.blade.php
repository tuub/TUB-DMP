@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')
    <!-- http://bootstrapswitch.com/options.html -->
    <script>
        $( function() {
            $( "input[type=checkbox]" ).bootstrapSwitch({
                size: 'mini',
                onText: 'Yes',
                onColor: 'success',
                offText: 'No',
                offColor: 'default',
            });
        } );
    </script>

    <style>
        * { outline: 0px #336699 solid; }
        label { padding-right: 20px; }
        textarea { resize: vertical; }
    </style>

    {!! Form::model($question, ['method' => $method, 'route' => ['admin.question.' . $action, $question->id], 'class' => '', 'role' => 'form']) !!}
    <legend>{{ trans('admin/question.title.' . $mode) }}</legend>
    {!! Form::hidden('template_id', $template->id) !!}

    <div class="row">
        <div class="form-group col-md-2">
            {!! Form::Label( 'keynumber', trans('admin/question.form.label.keynumber') ) !!}
            {!! Form::Text( 'keynumber', Input::old('keynumber'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('keynumber') ? 'form-error' : '') }}">{{ $errors->first('keynumber') }}</span>
        </div>
        <div class="control-group col-md-4 col-md-offset-18 text-right">
            <div class="controls">
                {!! Form::Label( 'is_active', trans('admin/question.form.label.is_active') ) !!}
                {!! Form::hidden('is_active', '0') !!}
                {!! Form::checkbox('is_active', 1, old('is_active')) !!}
            </div>
            <div class="controls">
                {!! Form::Label( 'is_mandatory', trans('admin/question.form.label.is_mandatory') ) !!}
                {!! Form::hidden('is_mandatory', '0') !!}
                {!! Form::checkbox('is_mandatory', 1, old('is_mandatory')) !!}
            </div>
            <div class="controls">
                {!! Form::Label( 'read_only', trans('admin/question.form.label.read_only') ) !!}
                {!! Form::hidden('read_only', '0') !!}
                {!! Form::checkbox('read_only', 1, old('read_only')) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::Label( 'text', trans('admin/question.form.label.text') ) !!}
            {!! Form::Textarea( 'text', Input::old('text'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('text') ? 'form-error' : '') }}">{{ $errors->first('text') }}</span>
        </div>
        <div class="form-group col-md-12">
            {!! Form::Label( 'output_text', trans('admin/question.form.label.output_text') ) !!}
            {!! Form::Textarea( 'output_text', Input::old('output_text'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('output_text') ? 'form-error' : '') }}">{{ $errors->first('output_text') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::Label( 'section_id', trans('admin/question.form.label.section') ) !!}
            {!! Form::select('section_id', $sections, Input::old('section_id'), array('class' => 'form-control')) !!}
            <span class="help-block {{ ($errors->first('section_id') ? 'form-error' : '') }}">{{ $errors->first('section_id') }}</span>
        </div>
        <div class="form-group col-md-12">
            {!! Form::Label( 'parent_id', trans('admin/question.form.label.parent') ) !!}
            {!! Form::select('parent_id', [null => 'None'] + $questions->toArray(), Input::old('parent_id'), array('class' => 'form-control')) !!}
            <span class="help-block {{ ($errors->first('parent_id') ? 'form-error' : '') }}">{{ $errors->first('parent_id') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6" id="vue-instance">
        {!! Form::Label( 'content_type_id', trans('admin/question.form.label.content_type') ) !!}
        {!! Form::select('content_type_id', $content_types->toArray(), $content_types->keys()->first(), array('class' => 'form-control', 'v-model' => 'content_type',  'v-on:change' => 'showOptions')) !!}
        <!--<pre>@{{ $data | json }}</pre>-->
            <span class="help-block {{ ($errors->first('content_type_id') ? 'form-error' : '') }}">{{ $errors->first('content_type_id') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'value', trans('admin/question.form.label.value') ) !!}
            {!! Form::Textarea( 'value', Input::old('value'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('value') ? 'form-error' : '') }}">{{ $errors->first('value') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'default', trans('admin/question.form.label.default') ) !!}
            {!! Form::Textarea( 'default', Input::old('default'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('default') ? 'form-error' : '') }}">{{ $errors->first('default') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::Label( 'prepend', trans('admin/question.form.label.prepend') ) !!}
            {!! Form::Text( 'prepend', Input::old('prepend'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('prepend') ? 'form-error' : '') }}">{{ $errors->first('prepend') }}</span>
        </div>
        <div class="form-group col-md-12">
            {!! Form::Label( 'append', trans('admin/question.form.label.append') ) !!}
            {!! Form::Text( 'append', Input::old('append'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('append') ? 'form-error' : '') }}">{{ $errors->first('append') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'comment', trans('admin/question.form.label.comment') ) !!}
            {!! Form::Text( 'comment', Input::old('comment'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('comment') ? 'form-error' : '') }}">{{ $errors->first('comment') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'reference', trans('admin/question.form.label.reference') ) !!}
            {!! Form::Text( 'reference', Input::old('reference'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('reference') ? 'form-error' : '') }}">{{ $errors->first('reference') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'guidance', trans('admin/question.form.label.guidance') ) !!}
            {!! Form::Textarea( 'guidance', Input::old('guidance'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('guidance') ? 'form-error' : '') }}">{{ $errors->first('guidance') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'hint', trans('admin/question.form.label.hint') ) !!}
            {!! Form::Textarea( 'hint', Input::old('hint'), array('class' => 'form-control') ) !!}
            <span class="help-block {{ ($errors->first('hint') ? 'form-error' : '') }}">{{ $errors->first('hint') }}</span>
        </div>
    </div>
    <div class="col-md-24 text-center">
        {!! Form::submit(trans('admin/question.form.label.submit.' . $mode), array('class' => 'button btn btn-success')) !!}
    </div>
    {!! Form::close() !!}

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