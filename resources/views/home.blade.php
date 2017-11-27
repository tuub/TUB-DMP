@extends('layouts.home')

@section('body')

    <div class="modal-dialog">
        <style>
            .withImageAndIcon {
                font-weight: bold;
            }

            .withImageAndIcon > div {
                vertical-align: middle;
                display:inline-block;
                margin-right: 0.2em;
            }

            /*
            .withImageAndIcon > div > i {
                float: right;
                line-height:72px;
                color: green;
                text-shadow: 2px 2px 0 rgba(255,255,255,1), -2px 2px 0 rgba(255,255,255,1),2px -2px 0 rgba(255,255,255,1), -2px -2px 0 rgba(255,255,255,1);
            }
            */

            .withTU48 {
                line-height: 15px;
                width: 50px;
                height: 30px;
                padding-left: 50px;
                background: transparent url('/images/logo/logo-tu-small.png') no-repeat;
            }
        </style>

        <div class="modal-content">
            {!! Form::open(array('route' => 'shibboleth-login', 'class' => '', 'method' => 'get', 'id' => 'login-form')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-24">
                        <p class="lead">
                            {{ trans('home.feature-header') }}
                        </p>
                        <p>
                            {{ trans('home.intro') }}
                        </p>
                        <ul class="list-unstyled" style="line-height: 2">
                            <li><span class="fa fa-check text-success"></span> {{ trans('home.feature-01') }}</li>
                            <li><span class="fa fa-check text-success"></span> {{ trans('home.feature-02') }}</li>
                            <li><span class="fa fa-check text-success"></span> {{ trans('home.feature-03') }}</li>
                            <li><span class="fa fa-check text-success"></span> {{ trans('home.feature-04') }}</li>
                            <li><span class="fa fa-check text-success"></span> {{ trans('home.feature-05') }}</li>
                            <li><span class="fa fa-check text-success"></span> {{ trans('home.feature-06') }}</li>
                        </ul>
                        <p>
                            <strong>{{ trans('home.feature-footer') }}</strong>
                        </p>
                        <p>
                            {!! html_entity_decode(HTML::link('http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/', trans('home.info-link-01'), ['class' => 'btn btn-fancy', 'target' => '_blank'])) !!}
                            &nbsp;&nbsp;&nbsp;
                            {!! html_entity_decode(HTML::link('http://www.szf.tu-berlin.de/menue/personen/ansprechpartnerinnen/', trans('home.info-link-02'), ['class' => 'btn btn-fancy', 'target' => '_blank'])) !!}
                        </p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-24">
                        <p class="lead">
                            {{ trans('login.header') }}
                        </p>

                        <u>{{ trans('login.privacy-statement-intro') }}</u>
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('privacy-statement-1', null, array('class' => 'form-control')) !!}
                                {{ trans('login.privacy-statement-1') }}
                                <span class="help-block {{ ($errors->first('privacy-statement-1') ? 'form-error' : '') }}">{{ $errors->first('privacy-statement-1') }}</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('privacy-statement-2', null, array('class' => 'form-control')) !!}
                                {{ trans('login.privacy-statement-2') }}
                                <span class="help-block {{ ($errors->first('privacy-statement-2') ? 'form-error' : '') }}">{{ $errors->first('privacy-statement-2') }}</span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default col-md-9 col-md-offset-6 col-sm-12 col-sm-offset-5 col-xs-9 col-xs-offset-1">
                            <div class="withTU48">
                                {!! trans('login.label-submit') !!}
                            </div>
                        </button>
                        @if (false)
                            <button type="submit" class="btn btn-default btn-sm col-md-12 col-md-offset-6 withImageAndIcon">
                                <div class="fa-lg withTU48"></div><br/>
                                {{ trans('login.label-submit') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if(env('APP_SERVER') == 'test')
        @include('partials.layout.testsystem.box')
    @endif
























    @if( false )

    <script>
        $(document).ready(function(){

            var csrftoken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrftoken } });

            $('#register-form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{!! route('register') !!}',
                    data: $(this).serialize()
                })
                .success(function (data) {
                    console.log(data);
                })
                .done(function (data) {
                    //$('#response').html(data);
                    console.log(data);
                })
                .fail(function (response) {
                    var errors = response.responseJSON;
                    errors.forEach(function(entry) {
                        console.log(entry);
                    });

                });
                return true;
            });
        });
    </script>


    <div class="modal fade" id="register-form" tabindex="-1" role="dialog" aria-labelledby="register-form">
        {!! Form::open(array('route' => 'register', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'register-form'))  !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Get your account</h4>
                </div>
                <div class="modal-body">
                    <p style="font-size: 120%;">In order to create your account we need some information regarding your TUB project.</p>
                    {!! csrf_field() !!}
                    {!! Form::label('account_project_number', 'TUB Project Number', array('class' => 'control-label')) !!}
                    {!! Form::text('account_project_number', '', array('class' => 'form-control', 'placeholder' => '')) !!}
                    {!! Form::label('account_name', 'Principal Investigator', array('class' => 'control-label')) !!}
                    {!! Form::text('account_name', '', array('class' => 'form-control', 'placeholder' => '')) !!}
                    {!! Form::label('account_email', 'Contact e-mail address', array('class' => 'control-label')) !!}
                    {!! Form::text('account_email', '', array('class' => 'form-control', 'placeholder' => '')) !!}
                    <div class="row form-group">
                        {!! Form::label('account_message', 'Additional Message', array('class' => 'control-label col-md-4')) !!}
                        <div class="col-md-12">
                            {!! Form::textarea('account_message', '', array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Your message, e.g. if you don\'t have a TUB project number')) !!}
                        </div>
                    </div>
                    <p style="font-size: 120%;">After reviewing your information we will get back to you as soon as possible.</p>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Send', array('class' => 'btn btn-success' )) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @endif








    @if( false )

        <div id="login-form" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <p class="lead">Login</p>
                            <div class="well">
                                {!! Form::open(array('route' => 'login', 'class' => '', 'method' => 'post')) !!}
                                    <div class="form-group input-group {{ ($errors->first('email') ? 'form-error' : '') }}">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        {!! Form::text( 'email', '', array('class' => 'form-control', 'placeholder' => trans('login.email') )) !!}
                                    </div>
                                    <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>
                                    <div class="form-group input-group {{ ($errors->first('password') ? 'form-error' : '') }}">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        {{-- Form::password('password', '', array('class' => 'form-control', 'placeholder' => trans('login.password') )) --}}
                                        <input class="form-control" type="password" name='password' placeholder="Your password"/>
                                    </div>
                                    <span class="help-block {{ ($errors->first('password') ? 'form-error' : '') }}">{{ $errors->first('password') }}</span>
                                    <br/>
                                    <strong>Please confirm:</strong>
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('privacy-statement-1', null, array('class' => 'form-control')) !!}
                                            {{ trans('login.privacy-statement-1') }}
                                            <span class="help-block {{ ($errors->first('privacy-statement-1') ? 'form-error' : '') }}">{{ $errors->first('privacy-statement-1') }}</span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('privacy-statement-2', null, array('class' => 'form-control')) !!}
                                            {{ trans('login.privacy-statement-2') }}
                                            <span class="help-block {{ ($errors->first('privacy-statement-2') ? 'form-error' : '') }}">{{ $errors->first('privacy-statement-2') }}</span>
                                        </label>
                                    </div>
                                    <br/>
                                    {!! Form::button( trans('login.submit') , array('type' => 'submit', 'name' => 'signin', 'class' => 'btn btn-block btn-success' )) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <p class="lead">Get your account</p>
                            <p>Our services include ...<p/>
                            <ul class="list-unstyled" style="line-height: 2">
                                <li><span class="fa fa-check text-success"></span> A step by step workflow</li>
                                <li><span class="fa fa-check text-success"></span> A checklist for your DMP</li>
                                <li><span class="fa fa-check text-success"></span> Prefilled categories</li>
                                <li>
                                    <span class="fa fa-check text-success"></span> A bundle of nice functions like:
                                    <ul type="square">
                                        <li>E-mail your DMP to your colleagues</li>
                                        <li>Export your DMP as PDF</li>
                                        <li>Create new versions of your DMP</li>
                                    </ul>
                                </li>
                                <li><span class="fa fa-check text-success"></span> TUB-DMP helps you easily to meet the requirements of Horizon 2020</li>
                                <br/>
                                {!! Form::button('Get your account now', ['class' => 'btn btn-success-btn-block btn-success btn-large large-text']) !!}
                                <br/><br/>
                                <li><a href="http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/" target="_blank">More about TUB-DMP</a></li>
                                <li><a href="http://www.szf.tu-berlin.de/menue/personen/ansprechpartnerinnen/" target="_blank">Get in touch with us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop