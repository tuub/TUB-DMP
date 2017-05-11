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
                {!! BootForm::text('Name', 'name')->placeholder('John Doe')->value( auth()->user()->name ) !!}
                {!! BootForm::text('Email', 'email')->placeholder('john.doe@example.org')->value( auth()->user()->email ) !!}
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