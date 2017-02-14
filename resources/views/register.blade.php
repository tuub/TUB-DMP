@extends('layouts.bootstrap')

@section('headline')

@stop

@section('body')

    <br/><br/><br/>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                {{ trans('register.header') }}
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => 'register', 'class' => '', 'method' => 'post')) !!}
                <p style="font-size: 120%;">In order to create your account we need some information regarding your TUB project.</p>
                <br/>
                {!! csrf_field() !!}
                <div>
                    {!! Form::label('project_number', 'TUB Project Number', array('class' => 'control-label')) !!}
                    {!! Form::text('project_number', '', array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('project_number') ? 'form-error' : '') }}">{{ $errors->first('project_number') }}</span>

                <div>
                    {!! Form::label('real_name', 'Principal Investigator', array('class' => 'control-label')) !!}
                    {!! Form::text('real_name', '', array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('real_name') ? 'form-error' : '') }}">{{ $errors->first('real_name') }}</span>

                <div>
                    {!! Form::label('email', 'Contact e-mail address', array('class' => 'control-label')) !!}
                    {!! Form::text('email', '', array('class' => 'form-control', 'placeholder' => '')) !!}
                </div>
                <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>

                <div>
                    {!! Form::label('message', 'Additional Message', array('class' => 'control-label')) !!}
                    {!! Form::textarea('message', '', array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Your message, e.g. if you don\'t have a TUB project number')) !!}
                </div>
                <br/>
                <p style="font-size: 120%;">After receiving your request, we will get back to you as soon as possible.</p>
                <div class="pull-left">
                    {!! HTML::linkRoute('home', 'Back', [], ['title' => "Back", 'class' => 'btn btn-default']) !!}
                </div>
                <div class="pull-right">
                    {!! Form::submit('Send', array('class' => 'btn btn-success' )) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>


@stop