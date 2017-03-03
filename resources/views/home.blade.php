@extends('layouts.bootstrap')

@section('body')

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-24">
                        <p class="lead">Welcome</p>
                        <br/><br/><br/>
                        @if( false )
                            {!! Form::button('Get your account', ['data-toggle' => "modal", 'data-target' => "#register-form", 'title' => "Get your account", 'class' => 'btn btn-success btn-success btn-xl large-text']) !!}
                        @endif
                        {!! HTML::linkRoute('register', 'Get your account', [], ['title' => "Get your account", 'class' => 'btn btn-success btn-success btn-xl large-text', 'style' => 'color: #fff;']) !!}

                        <br/><br/><p class="small">TUB-DMP is limited to TUB members</p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-24">
                        <p class="lead">Our service</p>
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
                            <li><a href="http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/" target="_blank">More Information</a></li>
                            <li><a href="http://www.szf.tu-berlin.de/menue/personen/ansprechpartnerinnen/" target="_blank">Get in touch with us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br/><br/>
        <div class="modal-content">
            {!! Form::open(array('route' => 'login', 'class' => '', 'method' => 'post', 'id' => 'login-form')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-24">
                        <p><strong>Login</strong></p>
                        <!--<div class="well">-->
                            <div class="form-group input-group {{ ($errors->first('email') ? 'form-error' : '') }}" style="margin-top: 14px;">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text( 'email', old('email'), array('class' => 'form-control', 'placeholder' => trans('login.email') )) !!}
                            </div>
                            <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>
                            <div class="form-group input-group {{ ($errors->first('password') ? 'form-error' : '') }}">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{-- Form::password('password', '', array('class' => 'form-control', 'placeholder' => trans('login.password') )) --}}
                                <input class="form-control" type="password" name='password' placeholder="Your password"/>
                            </div>
                            <span class="help-block {{ ($errors->first('password') ? 'form-error' : '') }}">{{ $errors->first('password') }}</span>
                        <!--</div>-->
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-24">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-24">
                        {!! Form::button( trans('login.submit') , array('type' => 'submit', 'name' => 'signin', 'class' => 'btn btn-success col-md-2 col-xs-12 pull-right' )) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

























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