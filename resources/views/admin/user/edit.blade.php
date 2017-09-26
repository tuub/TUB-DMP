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
    {{ $user->email }}
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit User "{{ $user->email }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.user.update', $user->id], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'email', 'E-mail Address' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( 'email', $user->email, array('class' => 'form-control', 'readonly' => 'readonly') ) !!}
                            <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'institution_id', 'Institution' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::select('institution_id', [null => 'None'] + $institutions->toArray(), $user->institution_id, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            <span class="help-block {{ ($errors->first('institution_id') ? 'form-error' : '') }}">{{ $errors->first('institution_id') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_active', 'Active' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_active', 1, $user->is_active) !!} Yes
                            {!! Form::radio('is_active', 0, $user->is_active) !!} No
                            <span class="help-block {{ ($errors->first('is_active') ? 'form-error' : '') }}">{{ $errors->first('is_active') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( 'is_admin', 'Admin' ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::radio('is_admin', 1, $user->is_admin) !!} Yes
                            {!! Form::radio('is_admin', 0, $user->is_admin) !!} No
                            <span class="help-block {{ ($errors->first('is_admin') ? 'form-error' : '') }}">{{ $errors->first('is_admin') }}</span>
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