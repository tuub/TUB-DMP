@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'admin', 'Zurück zur Übersicht' ) }}</li>
        </ul>
    </li>
@stop

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')
    {{ $template->name }}
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit Template "{{ $template->name }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($template, ['method' => 'PUT', 'route' => ['admin.template.update', $template->id], 'class' => '', 'role' => 'form']) !!}
                <div class="form-group row container">
                    <div class="col-md-2">
                        {!! Form::Label( 'name', 'Name' ) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::Text( 'name', $template->name, array('class' => 'form-control') ) !!}
                        <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="row form-group container">
                    <div class="col-md-2">
                        {!! Form::Label( 'institution_id', 'Institution' ) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::select('institution_id', [null => 'None'] + $institutions->toArray(), $template->institution_id, array('class' => 'form-control') ) !!}
                        <span class="help-block {{ ($errors->first('institution_id') ? 'form-error' : '') }}">{{ $errors->first('institution_id') }}</span>
                    </div>
                </div>
                <div class="row form-group container">
                    <div class="col-md-2">
                        {!! Form::Label( 'is_active', 'Active', array('class' => 'control-label') ) !!}
                    </div>
                    <div class="col-md-10">
                        {!! Form::radio('is_active', 1, $template->is_active) !!} Yes
                        {!! Form::radio('is_active', 0, $template->is_active) !!} No
                        <span class="help-block {{ ($errors->first('is_active') ? 'form-error' : '') }}">{{ $errors->first('is_active') }}</span>
                    </div>
                </div>
                <div class="form-group row container">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class="col-md-10">
                        {!! Form::submit('Update', array('class' => 'button btn btn-success')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop