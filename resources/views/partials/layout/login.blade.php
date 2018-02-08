<div class="modal-dialog">
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
                    <div class="col-md-24 text-center">
                        <button type="submit" class="btn btn-default" style="font-weight: bold">
                            {!! HTML::image('images/logo/logo-tu-small.png', 'TU Berlin') !!}

                            @if (env('DEMO_MODE'))&nbsp;&nbsp;
                                {!! trans('login.label-submit.demo') !!}
                            @else
                                {!! trans('login.label-submit.production') !!}
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>