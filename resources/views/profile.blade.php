@extends('layouts.bootstrap')

@section('headline')

@stop

@section('body')

    <br/><br/><br/>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                {{ trans('profile.header') }}
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => 'update_profile', 'class' => '', 'method' => 'post')) !!}
                <br/>
                {!! csrf_field() !!}
                <div>
                    {!! Form::label('name', 'Name', array('class' => 'control-label')) !!}
                    {!! Form::text('name', Auth::user()->name, array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('real_name') ? 'form-error' : '') }}">{{ $errors->first('real_name') }}</span>
                <div>
                    {!! Form::label('email', 'Contact e-mail address', array('class' => 'control-label')) !!}
                    {!! Form::text('email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>
                <div>
                    {!! Form::label('new_password', 'New Password', array('class' => 'control-label')) !!}
                    {!! Form::password('new_password', array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('new_password') ? 'form-error' : '') }}">{{ $errors->first('new_password') }}</span>
                <div>
                    {!! Form::label('confirm_password', 'Confirm Password', array('class' => 'control-label')) !!}
                    {!! Form::password('confirm_password', array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('confirm_password') ? 'form-error' : '') }}">{{ $errors->first('confirm_password') }}</span>

                <div class="pull-left">
                    {!! HTML::link( URL::previous(), 'Back', ['title' => "Back", 'class' => 'btn btn-default']) !!}
                </div>
                <div class="pull-right">
                    {!! Form::submit('Update Profile', array('class' => 'btn btn-success' )) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
@stop