@extends('layouts.bootstrap')

@section('body')


<div class="row col-md-6 text-center">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            Loginsdv
        </div>
        <div class="panel-body">
            {!! Form::open(array('route' => 'login', 'class' => 'form-horizontal', 'method' => 'post')) !!}
            {!! csrf_field() !!}
            <div class="row col-md-12">
                <div class="form-group">
                    {!! Form::label('email', 'Your email address', array('class' => 'control-label col-md-5')) !!}
                    <div class="col-md-7">
                        {!! Form::text('email', '', array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="form-group">
                    {!! Form::label('password', 'Your password', array('class' => 'control-label col-md-5')) !!}
                    <div class="col-md-7">
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="form-group">
                    <div class="col-md-offset-5 col-md-7">
                        {!! Form::submit('Sign in', array('class' => 'btn btn-primary' )) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop