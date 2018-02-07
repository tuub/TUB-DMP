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

                {!! BootForm::text(trans('project.request.label.name'), 'name')->placeholder(trans('project.request.placeholder.name'))->value(auth()->user()->name)->readonly() !!}
                {!! BootForm::text(trans('project.request.label.email'), 'email')->placeholder(trans('project.request.placeholder.email'))->value(auth()->user()->email)->readonly() !!}
                {!! BootForm::text(trans('project.request.label.tub_om'), 'tub_om')->placeholder(trans('project.request.placeholder.person_identifier'))->value(auth()->user()->tub_om)->readonly() !!}
                {!! BootForm::text(trans('project.request.label.institution_identifier'), 'institution_identifier')->placeholder(trans('project.request.institution_identifier'))->value(auth()->user()->institution_identifier)->readonly() !!}
                {!! BootForm::text(trans('project.request.label.contact_email'), 'contact_email')->placeholder(trans('project.request.placeholder.contact_email'))->helpBlock(trans('project.request.help.contact_email')) !!}
                {!! BootForm::textarea(trans('project.request.label.message'), 'message') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('project.request.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('project.request.button.submit'))->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>