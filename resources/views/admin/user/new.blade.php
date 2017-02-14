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

@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            New User
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($user, ['method' => 'POST', 'route' => ['admin.user.store'], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'name', 'Name' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'name', Input::old('name'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'real_name', 'Real Name' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'real_name', Input::old('real_name'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('real_name') ? 'form-error' : '') }}">{{ $errors->first('real_name') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'email', 'E-mail Address' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'email', Input::old('email'), array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'institution_id', 'Institution' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('institution_id', [null => 'None'] + $institutions->toArray(), Input::old('institution_id'), array('class' => 'form-control')) !!}
                            <span class="help-block {{ ($errors->first('institution_id') ? 'form-error' : '') }}">{{ $errors->first('institution_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_active', 'Active' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_active', 1, Input::old('$user->is_active')) !!} Yes
                            {!! Form::radio('is_active', 0, Input::old('$user->is_active')) !!} No
                            <span class="help-block {{ ($errors->first('is_active') ? 'form-error' : '') }}">{{ $errors->first('is_active') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_admin', 'Admin' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_admin', 1, Input::old('$user->is_admin')) !!} Yes
                            {!! Form::radio('is_admin', 0, Input::old('$user->is_admin')) !!} No
                            <span class="help-block {{ ($errors->first('is_admin') ? 'form-error' : '') }}">{{ $errors->first('is_admin') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'new_password', 'New Password' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'new_password', null, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('new_password') ? 'form-error' : '') }}">{{ $errors->first('new_password') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'confirm_password', 'Confirm Password' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'confirm_password', null, array('class' => 'form-control') ) !!}
                            <span class="help-block {{ ($errors->first('confirm_password') ? 'form-error' : '') }}">{{ $errors->first('confirm_password') }}</span>
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