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
                <h4 class="modal-title">Request for new project</h4>
                For privacy and legal reasons, we have to check manually your connection to the provided research project.
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                {!! BootForm::text('Project ID', 'project_id')->helpBlock('Please provide a TUB project ID in order to import project metadata.<br/>Otherwise we provide you with a random project identifier.') !!}

                {!! BootForm::text('Name', 'name')->placeholder('John Doe')->value(auth()->user()->name)->readonly() !!}
                {!! BootForm::text('Email', 'email')->placeholder('john.doe@example.org')->value(auth()->user()->email)->readonly() !!}
                {!! BootForm::text('OM', 'identifier')->placeholder('12345')->value(auth()->user()->identifier)->readonly() !!}
                {!! BootForm::text('Kostenstelle', 'institution_identifier')->placeholder('4600100100')->value(auth()->user()->institution_identifier)->readonly() !!}

                {!! BootForm::textarea('Your message (optional)', 'message') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Send')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>