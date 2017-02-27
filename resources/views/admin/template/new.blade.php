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
            New Template
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($template, ['method' => 'POST', 'route' => ['admin.template.store'], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'name', 'Name' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'name', Input::old('name'), array('class' => 'form-control xs') ) !!}
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'institution_id', 'Institution' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('institution_id', $institutions, Input::old('institution_id'), array('class' => 'form-control', 'v-model' => 'input_type',  'v-on:change' => 'showOptions')) !!}
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_active', 'Active' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_active', 1, Input::old('$template->is_active')) !!} Yes
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