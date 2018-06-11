<!-- Show Project Modal -->
<div class="modal fade" id="show-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="show-project-{{ $project->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('project.show.title') }}</h4>
            </div>
            <div class="modal-body">

                @if ($project->hasParent())
                    <div class="alert alert-info">
                        <h4>Parent Project</h4>
                        <p>
                            <label>{{ $project->getMetadataLabel('identifier') }}:</label>
                            {{ $project->getParent()->identifier }}
                        </p>
                        <p>
                            @if( $project->getParent()->getMetadata('title') )
                                <label>{{ str_plural($project->getParent()->getMetadataLabel('title'), $project->getParent()->getMetadata('title')->count()) }}:</label>
                                <br/>
                                @foreach( $project->getParent()->getMetadata('title') as $title )
                                    {{ $title['content'] }}
                                    @unless( $loop->last )
                                        <br/>
                                    @endunless
                                @endforeach
                                <br/><br/>
                            @endif
                        </p>
                    </div>
                @endif

                <table class="metadata">
                    @if( $project->identifier )
                        <tr>
                            <td class="label">{{ $project->getMetadataLabel('identifier') }}:</td>
                            <td>{{ $project->identifier }}</td>
                        </tr>
                    @endif

                    @if( $project->plans_count )
                        <tr>
                            <td class="label">{{ str_plural(trans('project.show.plan'), $project->plans_count) }}:</td>
                            <td>{{ $project->plans_count }}</td>
                        </tr>
                    @endif

                    @if( $project->children_count )
                            <tr>
                                <td class="label">{{ str_plural(trans('project.show.sub_project'), $project->children_count) }}:</td>
                                <td>{{ $project->children_count }}</td>
                            </tr>
                    @endif

                    @if( $project->getMetadata('title') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('title'), $project->getMetadata('title')->count()) }}:</td>
                            <td>
                                @foreach( $project->getMetadata('title') as $title )
                                    {{ $title['content'] }}
                                    @unless( $loop->last )
                                        <br/>
                                    @endunless
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('begin') )
                        <tr>
                            <td class="label">{{ $project->getMetadataLabel('duration') }}:</td>
                            <td>
                                @foreach( $project->getMetadata('begin') as $begin )
                                    @date($begin) -
                                    @if( $project->getMetadata('end') )
                                        @foreach( $project->getMetadata('end') as $end )
                                            @date($end)
                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('abstract') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('abstract'), $project->getMetadata('abstract')->count()) }}:</td>
                            <td>
                                @foreach( $project->getMetadata('abstract') as $abstract )
                                    {{ $abstract['content'] }}
                                    @unless( $loop->last )
                                        <br/><br/>
                                    @endunless
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('leader') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('leader'), $project->getMetadata('leader')->count()) }}:</td>
                            <td>
                                @foreach( $project->getMetadata('leader') as $leader )
                                    {!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}
                                    @unless( $loop->last )
                                        <br/>
                                    @endunless
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('member') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}:</td>
                            <td>
                                @foreach( $project->getMetadata('member') as $member )
                                    {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}
                                    @unless( $loop->last )
                                        <br/>
                                    @endunless
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('partner') )
                        <tr>
                            <td>{{ str_plural($project->getMetadataLabel('partner'), $project->getMetadata('partner')->count()) }}:</td>
                            <td>
                                @foreach( $project->getMetadata('partner') as $partner )
                                    {{ $partner }}
                                    @unless( $loop->last )
                                        <br/>
                                    @endunless
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('funding_source') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}:</td>
                            <td>{!! $project->getMetadata('funding_source')->implode(', ') !!}</td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('funding_program') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('funding_program'), $project->getMetadata('funding_program')->count()) }}:</td>
                            <td>{!! $project->getMetadata('funding_program')->implode(', ') !!}</td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('grant_reference_number') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('grant_reference_number'), $project->getMetadata('grant_reference_number')->count()) }}:</td>
                            <td>{!! $project->getMetadata('grant_reference_number')->implode(', ') !!}</td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('project_management_organisation') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('project_management_organisation'), $project->getMetadata('project_management_organisation')->count()) }}:</td>
                            <td>{!! $project->getMetadata('project_management_organisation')->implode(', ') !!}</td>
                        </tr>
                    @endif

                    @if( $project->getMetadata('project_data_contact') )
                        <tr>
                            <td class="label">{{ str_plural($project->getMetadataLabel('project_data_contact'), $project->getMetadata('project_data_contact')->count()) }}:</td>
                            <td>{!! $project->getMetadata('project_data_contact')->implode(', ') !!}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="modal-footer">
                {{ Form::button(trans('project.show.button.submit'), ['class' => 'btn btn-success', 'data-dismiss' => 'modal']) }}
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
                    <div class="col-md-1 text-center" style="padding-top: 7px;">-</div>
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
                {!! BootForm::button(trans('project.edit.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('project.edit.button.submit'))->class('btn btn-success') !!}
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
                <h4 class="modal-title">{{ (trans('plan.create.title')) }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ (trans('plan.create.description')) }}
                </p>
                <div class="errors"></div>
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::text(trans('plan.create.input.title.label'), 'title')->placeholder(trans('plan.create.input.title.placeholder')) !!}
                {!! BootForm::select(trans('plan.create.input.template.label'), 'template_id')->options($templates->sortBy('name')->pluck('name', 'id')) !!}
                {!! BootForm::text(trans('plan.create.input.version.label'), 'version')->placeholder(trans('plan.create.input.version.placeholder')) !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('plan.create.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('plan.create.button.submit'))->class('btn btn-success') !!}
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
                <h4 class="modal-title">{{ trans('plan.edit.title') }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ (trans('plan.edit.description')) }}
                </p>
                <div class="errors"></div>
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::text(trans('plan.edit.input.title.label'), 'title')->placeholder(trans('plan.edit.input.title.placeholder')) !!}
                {!! BootForm::text(trans('plan.edit.input.version.label'), 'version')->placeholder(trans('plan.edit.input.version.placeholder')) !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('plan.edit.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('plan.edit.button.submit'))->class('btn btn-success') !!}
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
                <h4 class="modal-title">{{ trans('plan.snapshot.title') }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ (trans('plan.snapshot.description')) }}
                </p>
                <p>
                    <div class="alert alert-danger">
                        {{ trans('plan.snapshot.danger') }}
                    </div>
                </p>
                <div class="errors"></div>
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::text(trans('plan.snapshot.input.title.label'), 'title') !!}
                {!! BootForm::text(trans('plan.snapshot.input.version.label'), 'version')->placeholder(trans('plan.snapshot.input.version.placeholder')) !!}
                {!! BootForm::checkbox(trans('plan.snapshot.input.clone_current.label'), 'clone_current')->check() !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('plan.snapshot.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('plan.snapshot.button.submit'))->class('btn btn-success') !!}
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
                <h4 class="modal-title">{{ trans('plan.email.title') }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ trans('plan.email.description') }}
                </p>
                <div class="errors"></div>
                {!! BootForm::hidden('id')->id('id') !!}
                {!! BootForm::hidden('project_id')->id('project_id') !!}
                {!! BootForm::hidden('version')->id('version') !!}
                {!! BootForm::text(trans('plan.email.input.name.label'), 'name')->placeholder(trans('plan.email.input.name.placeholder')) !!}
                {!! BootForm::text(trans('plan.email.input.email.label'), 'email')->placeholder(trans('plan.email.input.email.placeholder')) !!}
                {!! BootForm::textarea(trans('plan.email.input.message.label'), 'message') !!}
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('plan.email.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('plan.email.button.submit'))->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>