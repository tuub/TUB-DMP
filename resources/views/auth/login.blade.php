<div class="absolute_center is_responsive">
    <div class="col-md-4 col-xs-8 col-sm-10 col-md-offset-4 col-sm-offset-1 col-xs-offset-2">
        {!! Form::open(array('route' => 'login', 'class' => 'form-horizontal', 'method' => 'post')) !!}
            <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {!! Form::text( 'email', '', array('class' => 'form-control', 'placeholder' => trans('login.email') )) !!}
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input class="form-control" type="password" name='password' placeholder="Your password"/>
                <!--{!! Form::password('password', '', array('class' => 'form-control', 'placeholder' => trans('login.password') )) !!}-->
            </div>
            <!--
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('to_agree', '', array('class' => 'form-control')) !!}
                    {{ trans('login.privacy-statement') }}
                </label>
            </div>
            -->
            <div class="form-group">
                {!! Form::submit( trans('login.submit') , array('name' => 'signin', 'class' => 'btn btn-def btn-block btn-success' )) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
