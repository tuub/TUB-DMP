<!-- Feedback Modal -->
<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="feedback">
    {!! BootForm::open()->id('feedback-form')->action( route('feedback') )->post() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Leave us a Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                {!! BootForm::text('Name', 'name')->placeholder('John Doe')->value( auth()->user()->name )->readonly() !!}
                {!! BootForm::text('Email', 'email')->placeholder('john.doe@example.org')->value( auth()->user()->email)->readonly() !!}
                {!! BootForm::textarea('Your Feedback message', 'message') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Send')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>

<!-- New Project Modal -->
<div class="modal fade" id="project-request" tabindex="-1" role="dialog" aria-labelledby="project-request">
    {!! BootForm::open()->id('project-request-form')->action( route('project.request') )->post() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('project.request.title') }}</h4>
                {!! trans('project.request.subtitle') !!}
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                {!! BootForm::hidden('user_id')->value(auth()->user()->id) !!}
                {!! BootForm::text(trans('project.request.label.identifier'), 'identifier')->helpBlock(trans('project.request.help.identifier')) !!}
                <span class="help-block {{ ($errors->first('identifier') ? 'form-error' : '') }}">{{ $errors->first('identifier') }}</span>

                {!! BootForm::text(trans('project.request.label.name'), 'name')->placeholder(trans('project.request.placeholder.name'))->value(auth()->user()->name)->readonly() !!}
                <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>

                {!! BootForm::text(trans('project.request.label.email'), 'email')->placeholder(trans('project.request.placeholder.email'))->value(auth()->user()->email)->readonly() !!}
                <span class="help-block {{ ($errors->first('email') ? 'form-error' : '') }}">{{ $errors->first('email') }}</span>

                {!! BootForm::text(trans('project.request.label.tub_om'), 'tub_om')->placeholder(trans('project.request.placeholder.person_identifier'))->value(auth()->user()->tub_om)->readonly() !!}
                <span class="help-block {{ ($errors->first('tub_om') ? 'form-error' : '') }}">{{ $errors->first('tub_om') }}</span>

                {!! BootForm::text(trans('project.request.label.institution_identifier'), 'institution_identifier')->placeholder(trans('project.request.placeholder.institution_identifier'))->value(auth()->user()->institution_identifier)->readonly() !!}
                <span class="help-block {{ ($errors->first('institution_identifier') ? 'form-error' : '') }}">{{ $errors->first('institution_identifier') }}</span>

                {!! BootForm::text(trans('project.request.label.contact_email'), 'contact_email')->placeholder(trans('project.request.placeholder.contact_email'))->helpBlock(trans('project.request.help.contact_email')) !!}
                <span class="help-block {{ ($errors->first('contact_email') ? 'form-error' : '') }}">{{ $errors->first('contact_email') }}</span>

                {!! BootForm::textarea(trans('project.request.label.message'), 'message') !!}
                <span class="help-block {{ ($errors->first('message') ? 'form-error' : '') }}">{{ $errors->first('message') }}</span>
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('project.request.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                @if (env('DEMO_MODE'))
                    {!! BootForm::submit(trans('project.request.button.submit.demo'))->class('btn btn-success') !!}
                @else
                    {!! BootForm::submit(trans('project.request.button.submit.production'))->class('btn btn-success') !!}
                @endif
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>