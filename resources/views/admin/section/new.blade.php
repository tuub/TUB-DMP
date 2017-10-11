@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'admin.dashboard', 'Zurück zur Übersicht' ) }}</li>
        </ul>
    </li>
@stop

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')

@stop

@section('body')
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            New Section
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($section, ['method' => 'POST', 'route' => ['admin.section.store'], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'keynumber', 'Keynumber' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::text('keynumber', Input::old('keynumber'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('keynumber') ? 'form-error' : '') }}">{{ $errors->first('keynumber') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'name', 'Name' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'name', Input::old('name'), array('class' => 'form-control xs') ) !!}
                            <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'template_id', 'Template' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('template_id', $templates, Input::old('template_id'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('template_id') ? 'form-error' : '') }}">{{ $errors->first('template_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'order', 'Order' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::text('order', Input::old('order'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('order') ? 'form-error' : '') }}">{{ $errors->first('order') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'guidance', 'Guidance' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Textarea( 'guidance', Input::old('guidance'), array('class' => 'form-control xs') ) !!}
                            <span class="help-block {{ ($errors->first('guidance') ? 'form-error' : '') }}">{{ $errors->first('guidance') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_active', 'Active' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_active', 1, Input::old('$template->is_active'), ['checked' => 'checked']) !!} Yes
                            {!! Form::radio('is_active', 0, Input::old('$template->is_active')) !!} No
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
@stop