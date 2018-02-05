@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    {{ Breadcrumbs::render('project_form', $user, $project, $mode) }}

    {!! Form::model($project, ['method' => $method, 'route' => ['admin.project.' . $action, $project->id], 'class' => '', 'role' => 'form']) !!}
    <legend>{{ trans('admin/project.title.' . $mode) }}</legend>
    {!! Form::hidden('user_id', $user->id) !!}
    {!! Form::hidden('return_route', $return_route) !!}
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::Label( 'identifier', trans('admin/project.form.label.identifier') ) !!}
            {!! Form::Text( 'identifier', Input::old('identifier'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('identifier') ? 'form-error' : '') }}">{{ $errors->first('identifier') }}</span>
        </div>
        <div class="control-group col-md-4 col-md-offset-14 text-right">
            <div class="controls">
                {!! Form::Label( 'is_active', trans('admin/question.form.label.is_active') ) !!}
                {!! Form::hidden('is_active', '0') !!}
                {!! Form::checkbox('is_active', 1, old('is_active', $project->is_active)) !!}
            </div>
        </div>
    </div>
    <div class="row" id="project-relations">
        <div class="form-group col-md-24">
            {!! Form::Label( 'parent_id', trans('admin/project.form.label.parent') ) !!}
            <select id="parent_id" name="parent_id" class="form-control" :disabled="projects == ''">
                <option value="">{{ trans('form.dropdown.null') }}</option>
                <option v-for="project in projects" :value="project.id" :selected="project.id == '{{$project->parent_id}}' ? 'selected' : ''">@{{ project.identifier }}</option>
            </select>
            <span class="help-block {{ ($errors->first('parent_id') ? 'form-error' : '') }}">{{ $errors->first('parent_id') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::Label( 'data_source_id', trans('admin/project.form.label.data_source') ) !!}
            {!! Form::select('data_source_id', $data_sources->toArray(), $project->data_source->id ?? null, ['class' => 'form-control']) !!}
            <span class="help-block {{ ($errors->first('data_source_id') ? 'form-error' : '') }}">{{ $errors->first('data_source_id') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-24">
            {!! Form::Label( 'contact_email', trans('admin/project.form.label.contact_email') ) !!}
            {!! Form::Text( 'contact_email', Input::old('contact_email'), array('class' => 'form-control ') ) !!}
            <span class="help-block {{ ($errors->first('contact_email') ? 'form-error' : '') }}">{{ $errors->first('contact_email') }}</span>
        </div>
    </div>
    <div class="col-md-24 text-center">
        {!! Form::submit(trans('admin/project.form.label.submit.' . $mode), array('class' => 'button btn btn-success')) !!}
    </div>
    {!! Form::close() !!}

    <script>

        let project = '{!! $project->id !!}';
        let user = null;

        @if ($project->user)
            user = '{!! $project->user->id !!}';
                @endif

        let vm = new Vue({
                el: '#project-relations',
                data: {
                    user: user,
                    projects: {}
                },
                methods: {
                    fetchProjects() {
                        let vm = this;

                        axios.get('/api/projects', {
                            params: {
                                user: this.user
                            }
                        }).then((res) => {
                            let projects = res.data
                            // question cannot be its own parent so we filter that out
                            projects = projects.filter(function(el) {
                                return el.id !== project;
                            });
                            axios.get('/api/project/possible_parents', {
                                params: {
                                    project: project,
                                    user: user
                                }
                            }).then((res) => {
                                this.projects = res.data;
                            })
                        })
                    },
                },

                created: function() {

                },

                mounted: function() {
                    //let vm = this;
                    self.user = user;
                    self.projects = this.fetchProjects();
                }
            })
    </script>
@stop