@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('question_form', $template, $section, $question, $mode) }}

    {!! Form::model($question, ['method' => $method, 'route' =>  ['admin.question.' . $action, $question->id], 'class' => '', 'role' => 'form']) !!}
        <legend>{{ trans('admin/question.title.' . $mode) }}</legend>
        {!! Form::hidden('order', ($position ?? $question->order)) !!}
        {!! Form::hidden('template_id', $template->id) !!}
        <div class="row">
            <div class="form-group col-md-2">
                {!! Form::Label( 'keynumber', trans('admin/question.form.label.keynumber') ) !!}
                {!! Form::Text( 'keynumber', $question->keynumber ?? $position, array('class' => 'form-control ') ) !!}
                <span class="help-block {{ ($errors->first('keynumber') ? 'form-error' : '') }}">{{ $errors->first('keynumber') }}</span>
            </div>
            <div class="control-group col-md-6 col-md-offset-16 text-right">
                <div class="controls">
                    {!! Form::Label( 'is_active', trans('admin/question.form.label.is_active') ) !!}
                    {!! Form::hidden('is_active', '0') !!}
                    {!! Form::checkbox('is_active', 1, old('is_active', $question->is_active)) !!}
                </div>
                <div class="controls">
                    {!! Form::Label( 'is_mandatory', trans('admin/question.form.label.is_mandatory') ) !!}
                    {!! Form::hidden('is_mandatory', '0') !!}
                    {!! Form::checkbox('is_mandatory', 1, old('is_mandatory', $question->is_mandatory)) !!}
                </div>
                <div class="controls">
                    {!! Form::Label( 'read_only', trans('admin/question.form.label.read_only') ) !!}
                    {!! Form::hidden('read_only', '0') !!}
                    {!! Form::checkbox('read_only', 1, old('read_only', $question->read_only)) !!}
                </div>
                <div class="controls">
                    {!! Form::Label( 'export_always', trans('admin/question.form.label.export_always') ) !!}
                    {!! Form::hidden('export_always', '0') !!}
                    {!! Form::checkbox('export_always', 1, old('export_always', $question->export_always)) !!}
                </div>
                <div class="controls">
                    {!! Form::Label( 'export_never', trans('admin/question.form.label.export_never') ) !!}
                    {!! Form::hidden('export_never', '0') !!}
                    {!! Form::checkbox('export_never', 1, old('export_never', $question->export_never)) !!}
                </div>
                <div class="controls">
                    {!! Form::Label( 'export_keynumber', trans('admin/question.form.label.export_keynumber') ) !!}
                    {!! Form::hidden('export_keynumber', '0') !!}
                    {!! Form::checkbox('export_keynumber', 1, old('export_keynumber', $question->export_keynumber)) !!}
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
        <div class="row" id="question-relations">
            <div class="form-group col-md-12">
                {!! Form::Label( 'section_id', trans('admin/question.form.label.section') ) !!}

                <select id="section_id" name="section_id" class="form-control" v-model="section_filter" @change="fetchQuestions">
                    <option value="">{{ trans('form.dropdown.null') }}</option>
                    <option v-for="section in sections"
                            :value="section.id">
                        @{{ section.name }}
                    </option>
                </select>
                <span class="help-block {{ ($errors->first('section_id') ? 'form-error' : '') }}">{{ $errors->first('section_id') }}</span>
            </div>
            <div class="form-group col-md-12">
                {!! Form::Label( 'parent_id', trans('admin/question.form.label.parent') ) !!}
                <select id="parent_id" name="parent_id" class="form-control" :disabled="section_filter == ''">
                    <option value="">{{ trans('form.dropdown.null') }}</option>
                        <option v-for="question in questions" :value="question.id" :selected="question.id == '{{$question->parent_id}}' ? 'selected' : ''">@{{ question.text }}</option>
                </select>
                <span class="help-block {{ ($errors->first('parent_id') ? 'form-error' : '') }}">{{ $errors->first('parent_id') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::Label( 'content_type_id', trans('admin/question.form.label.content_type') ) !!}
                {!! Form::select('content_type_id', $content_types->toArray(), $question->content_type->id ?? \App\ContentType::getDefault()->id, ['class' => 'form-control']) !!}
                <span class="help-block {{ ($errors->first('content_type_id') ? 'form-error' : '') }}">{{ $errors->first('content_type_id') }}</span>
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
            <div class="form-group col-md-24">
                {!! Form::Label( 'comment', trans('admin/question.form.label.comment') ) !!}
                {!! Form::Text( 'comment', Input::old('comment'), array('class' => 'form-control') ) !!}
                <span class="help-block {{ ($errors->first('comment') ? 'form-error' : '') }}">{{ $errors->first('comment') }}</span>
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
                {!! Form::Label( 'reference', trans('admin/question.form.label.reference') ) !!}
                {!! Form::Text( 'reference', Input::old('reference'), array('class' => 'form-control') ) !!}
                <span class="help-block {{ ($errors->first('reference') ? 'form-error' : '') }}">{{ $errors->first('reference') }}</span>
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
            {!! HTML::link(URL::previous(), trans('form.label.cancel'), ['class' => 'btn btn-default']) !!}
        </div>
    {!! Form::close() !!}

    <script>

        let question = '{!! $question->id !!}'
        let template = '{!! $template->id !!}'

        @if ($question->section)
            let section = '{!! $question->section->id !!}'
        @else
            let section = '{!! $section->id !!}'
        @endif

        let vm = new Vue({
            el: '#question-relations',
            data: {
                template_filter: template,
                section_filter: section,
                questions: {},
                sections: {}
            },

            computed: {
                isDisabled() {
                    return true
                }
            },

            /*
            watch: {
                section_filter: function() {
                    self.questions = this.fetchQuestions();
                }
            },
            */

            methods: {
                fetchSections() {
                    let vm = this;
                    axios.get('/api/sections', {
                        params: { template: this.template_filter }
                    })
                    .then((res) => {
                        this.sections = res.data
                    })
                },
                fetchQuestions() {
                    let vm = this;
                    if(this.section_filter) {

                        axios.get('/api/questions', {
                            params: {
                                section: this.section_filter
                            }
                        }).then((res) => {
                            let questions = res.data
                            // question cannot be its own parent so we filter that out
                            questions = questions.filter(function(el) {
                                return el.id != question;
                            });
                            axios.get('/api/question/possible_parents', {
                                params: {
                                    section: this.section_filter,
                                    question: question
                                }
                            }).then((res) => {
                                this.questions = res.data;
                            })
                            //this.questions = questions;
                        })
                    } else {
                        this.questions = {}
                    }
                },
            },

            created: function() {

            },

            mounted: function() {
                //let vm = this;
                //console.log(vm.$root)
                self.template_filter = template;
                self.sections = this.fetchSections();
                self.questions = this.fetchQuestions();
            }
        })
    </script>
@stop