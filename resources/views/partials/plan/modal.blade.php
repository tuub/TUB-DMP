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
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::text('DMP Title', 'title')->placeholder('My Data Management Plan') !!}
                {!! BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) !!}
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
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::text('DMP Title', 'title')->helpBlock('A good title would help.') !!}
                {!! BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) !!}
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

@if( false )
    <div class="bootstrap-modal-form modal fade" id="create-plan" tabindex="-1" role="dialog" aria-labelledby="create-option">
        {!! Form::open(['route' => ['store_plan'], 'method' => 'post', 'class' => 'form', 'id' => 'create_plan'])  !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create DMP in Project {{ $plan->project->identifier }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden( 'project_id', $project->id) !!}
                    {!! csrf_field() !!}
                    {!! Form::label('title', 'Plan Title', ['class' => 'control-label']) !!}
                    {!! Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'My Data Management Plan']) !!}
                    {!! Form::label('template_id', 'Plan Template', ['class' => 'control-label']) !!}
                    {!! Form::select('template_id', $templates->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Select Template']) !!}
                </div>
                <div class="modal-footer">
                {!! Form::submit('Add DMP', array('class' => 'btn btn-success' )) !!}
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endif

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

    <div class="modal fade" id="email-option-for-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="email-option-for-{{ $plan->id }}">
        {!! Form::open(array('route' => array('email_plan'), 'method' => 'post', 'class' => 'form-inline', 'id' => 'email_plan'))  !!}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Send DMP via e-mail</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::hidden( 'project_number', $plan->project_number) !!}
                        {!! Form::hidden( 'version', $plan->version) !!}
                        {!! csrf_field() !!}
                        {!! Form::label('name', 'Recipient name', array('class' => 'control-label')) !!}
                        {!! Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'John Doe')) !!}
                        {!! Form::label('email', 'Recipient e-mail', array('class' => 'control-label')) !!}
                        {!! Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'john.doe@example.org')) !!}
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Send', array('class' => 'btn btn-success' )) !!}
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="version-option-for-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="version-option-for-{{ $plan->id }}">
        {!! Form::open(array('route' => array('version_plan'), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'version_plan'))  !!}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Confirm new version</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure that you want to create the next version of your DMP?<br/><br/>
                        <strong>Once you created version {{ $plan->version+1 }} of your DMP, you will not be able to edit the data of your current version.</strong>
                        {!! Form::hidden( 'project_number', $plan->project_number) !!}
                        {!! Form::hidden( 'version', $plan->version) !!}
                        {!! csrf_field() !!}
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Yes', array('class' => 'btn btn-success' )) !!}
                        {!! Form::reset('No', array('class' => 'btn btn-danger', 'data-dismiss' => 'modal' )) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endif