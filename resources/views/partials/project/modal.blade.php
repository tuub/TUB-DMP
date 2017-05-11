<!-- Show Project Modal -->
<div class="modal fade" id="show-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="show-project-{{ $project->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Show Project Metadata</h4>
            </div>
            <div class="modal-body">
                @if( $project->identifier )
                    <label>{{ $project->getMetadataLabel('identifier') }}:</label>
                    {{ $project->identifier }}
                    <br/>
                @endif

                @if( $project->plans_count )
                    <label>{{ str_plural('Plan', $project->plans_count) }}:</label>
                    {{ $project->plans_count }}
                    <br/>
                @endif

                @if( $project->children_count )
                    <label>{{ str_plural('Sub Project', $project->children_count) }}:</label>
                    {{ $project->children_count }}
                    <br/>
                @endif

                @if( $project->getMetadata('title') )
                    <label>{{ str_plural($project->getMetadataLabel('title'), $project->getMetadata('title')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('title') as $title )
                        {{ strtoupper($title['language']) }}: {{ $title['content'] }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('begin') )
                    <label>{{ $project->getMetadataLabel('duration') }}:</label>
                    @foreach( $project->getMetadata('begin') as $begin )
                        @date($begin) -
                        @if( $project->getMetadata('end') )
                            @foreach( $project->getMetadata('end') as $end )
                                @date($end)
                            @endforeach
                        @endif
                    @endforeach
                    <br/>
                @endif

                @if( $project->getMetadata('abstract') )
                    <label>{{ str_plural($project->getMetadataLabel('abstract'), $project->getMetadata('abstract')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('abstract') as $abstract )
                        {{ strtoupper($abstract['language']) }}: {{ $abstract['content'] }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('leader') )
                    <label>{{ str_plural($project->getMetadataLabel('leader'), $project->getMetadata('leader')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('leader') as $leader )
                        {!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('member') )
                    <label>{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('member') as $member )
                        {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('partner') )
                    <label>{{ str_plural($project->getMetadataLabel('partner'), $project->getMetadata('partner')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('partner') as $partner )
                        {{ $partner }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('funding_source') )
                    <label>{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}:</label>
                    {!! $project->getMetadata('funding_source')->implode(', ') !!}
                    <br/><br/>
                @endif

                @if( $project->getMetadata('funding_program') )
                    <label>{{ str_plural($project->getMetadataLabel('funding_program'), $project->getMetadata('funding_program')->count()) }}:</label>
                    {!! $project->getMetadata('funding_program')->implode(', ') !!}
                    <br/><br/>
                @endif

                @if( $project->getMetadata('grant_reference_number') )
                    <label>{{ str_plural($project->getMetadataLabel('grant_reference_number'), $project->getMetadata('grant_reference_number')->count()) }}:</label>
                    {!! $project->getMetadata('grant_reference_number')->implode(', ') !!}
                    <br/><br/>
                @endif

                @if( $project->getMetadata('project_management_organisation') )
                    <label>{{ str_plural($project->getMetadataLabel('project_management_organisation'), $project->getMetadata('project_management_organisation')->count()) }}:</label>
                    {!! $project->getMetadata('project_management_organisation')->implode(', ') !!}
                    <br/><br/>
                @endif

                @if( $project->getMetadata('project_data_contact') )
                    <label>{{ str_plural($project->getMetadataLabel('project_data_contact'), $project->getMetadata('project_data_contact')->count()) }}:</label>
                    {!! $project->getMetadata('project_data_contact')->implode(', ') !!}
                    <br/><br/>
                @endif

            </div>
            <div class="modal-footer">
                {{ Form::button('OK', ['class' => 'btn btn-success', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>


<!-- Edit Project Modal -->
<div class="modal fade" id="edit-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-project-{{ $project->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! BootForm::open()->class('edit-project-form')->role('form')->data(['rel' => $project->id])->action( route('project.update') )->put() !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Project Metadata for {{ $project->identifier }}</h4>
            </div>
            <div class="modal-body">
                <!-- PROJECT_ID -->
                {!! BootForm::hidden('id')->id('id')->value($project->id) !!}

                <!-- PROJECT TITLE -->
                {!! Form::metadata( $project, 'title' ) !!}

                <!-- PROJECT DURATION -->
                <label>{{ $project->getMetadataLabel('begin') }} / {{ $project->getMetadataLabel('end') }}:</label>
                <div class="form-group row">
                    <div class="col-md-6">
                        @if( $project->getMetadata('begin') )
                            {!! Form::date('begin[]', $project->getMetadata('begin')->first(), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::date('begin[]', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <div class="col-md-1">-</div>
                    <div class="col-md-6">
                        @if( $project->getMetadata('end') and $project->getMetadata('end')->count() )
                            {!! Form::date('end[]', $project->getMetadata('end')->first(), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::date('end[]', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                </div>

                <!-- PROJECT STAGE -->
                {!! Form::metadata( $project, 'stage' ) !!}

                <!-- PROJECT ABSTRACT -->
                {!! Form::metadata( $project, 'abstract' ) !!}

                <!-- PROJECT LEADER -->
                {!! Form::metadata( $project, 'leader' ) !!}

                <!-- PROJECT MEMBERS -->
                {!! Form::metadata( $project, 'member' ) !!}

                <!-- EXTERNAL PROJECT PARTNER -->
                {!! Form::metadata( $project, 'partner' ) !!}

                <!-- FUNDING SOURCE -->
                {!! Form::metadata( $project, 'funding_source' ) !!}

                <!-- FUNDING PROGRAM -->
                {!! Form::metadata( $project, 'funding_program' ) !!}

                <!-- GRANT REFERENCE NUMBER -->
                {!! Form::metadata( $project, 'grant_reference_number' ) !!}

                <!-- PROJECT MANAGEMENT ORGANISATION -->
                {!! Form::metadata( $project, 'project_management_organisation' ) !!}

                <!-- PROJECT DATA CONTACT -->
                {!! Form::metadata( $project, 'project_data_contact' ) !!}

            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Update')->class('btn btn-success') !!}
            </div>
            {!! BootForm::close() !!}
        </div>
    </div>
</div>

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
                {!! BootForm::text('Version Description', 'version')->value('First DMP version') !!}
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
                {!! BootForm::text('Version Description', 'version') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Save')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>

<!-- Create Plan Snapshot Modal -->
<div class="modal fade" id="create-plan-snapshot" tabindex="-1" role="dialog" aria-labelledby="create-plan-snapshot">
    {!! BootForm::open()->id('create-plan-snapshot-form')->action( route('plan.snapshot') )->post() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Snapshot</h4>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                <p>
                    <strong>
                        Once you create a snapshot of your DMP, you will not be able to edit
                        the data of your current version.<br/>
                        By default, a new version will be created for you to continue editing.
                    </strong>
                </p>
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::text('DMP Title', 'title') !!}
                {!! BootForm::text('Version Description', 'version') !!}
                {!! BootForm::checkbox('Create new version from current plan', 'clone_current')->checked() !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Create Snapshot')->class('btn btn-success') !!}
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