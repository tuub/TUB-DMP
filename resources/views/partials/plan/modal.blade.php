<!-- Create Plan Modal -->
<div class="modal fade" id="create-plan" tabindex="-1" role="dialog" aria-labelledby="create-plan">
    {!! BootForm::open()->id('create-plan-form')->action( route('plan.store') )->put() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create DMP</h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::text('DMP Title', 'title')->placeholder('My Data Management Plan') !!}
                {!! BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) !!}
                {!! BootForm::text('DMP Version', 'version') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Create')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>

<!-- Edit Plan Modal -->
<div class="modal fade" id="edit-plan" tabindex="-1" role="dialog" aria-labelledby="edit-plan">
    {!! BootForm::open()->id('edit-plan-form')->action( route('plan.update') )->put() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit DMP</h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::text('DMP Title', 'title')->helpBlock('A good title would help.') !!}
                {!! BootForm::text('DMP Version', 'version') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Save')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>

<!-- Create Plan Version Modal -->
<div class="modal fade" id="create-plan-version" tabindex="-1" role="dialog" aria-labelledby="create-plan-version">
    {!! BootForm::open()->id('create-plan-version-form')->action( route('plan.version') )->post() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create DMP Version <span id="next-version">{{-- $plan->getNextVersion($plan->version) --}}</span></h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                <strong>
                    Once you created version <span id="current-version">{{-- $plan->version+1 --}}</span> of your DMP, you will not be able to edit
                    the data of your current version.
                </strong>
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::text('DMP Title', 'title') !!}
                {!! BootForm::checkbox('Clone current plan', 'clone_current')->checked() !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Create Version')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>


<!-- Email Plan Modal -->
<div class="modal fade" id="email-plan" tabindex="-1" role="dialog" aria-labelledby="email-plan">
    {!! BootForm::open()->id('email-plan-form')->action( route('plan.email') )->post() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Email DMP <span id="plan-title"></span></h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                Let your colleagues know about your DMP.
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::hidden('version')->id('version') !!}
                {!! BootForm::text('Name', 'name')->placeholder('John Doe') !!}
                {!! BootForm::text('Email', 'email')->placeholder('john.doe@example.org') !!}
                {!! BootForm::textarea('Your Message', 'message') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Send')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>

@if( false )
    <div class="modal fade" id="export-option-for-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="export-option-for-{{ $plan->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Choose Export Format</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Format</th>
                            <th>Description</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>PDF</td>
                            <td>Exports your DMP with all pre-filled and manually provided data.</td>
                            <td>
                                <a download href='{{URL::route('export_plan', [$plan->project_number, $plan->version, 'pdf'] )}}'>Open/Download</a>
                            </td>
                        </tr>

                    </table>

                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>
            </div>
        </div>
    </div>
@endif