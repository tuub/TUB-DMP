<!-- Show Project Modal -->
<div class="modal fade" id="show-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="show-project-{{ $project->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Project Metadata</h4>
            </div>
            <div class="modal-body">
                <label>Project Number</label>
                {{ $project->identifier }}
                <br/>
                <label>{{ str_plural('Plan', $project->plans_count) }}:</label>
                {{ $project->plans_count }}
                <br/>
                <label>{{ str_plural('Sub Project', $project->children_count) }}:</label>
                {{ $project->children_count }}
                <br/>
                <label>{{ str_plural($project->getMetadataLabel('title'), $project->getMetadata('title')->count()) }}:</label>
                <br/>
                @if( $project->getMetadata('title') )
                    @foreach( $project->getMetadata('title') as $key => $value )
                        {{ $value }} ({{ $key  }})<br/>
                    @endforeach
                @endif
                <br/>
                <label>Duration:</label>
                @if( $project->getMetadata('begin') )
                    @foreach( $project->getMetadata('begin') as $begin )
                        @date($begin) -
                        @if( $project->getMetadata('end') )
                            @foreach( $project->getMetadata('end') as $end )
                                @date($end)
                            @endforeach
                        @endif
                    @endforeach
                @endif
                <br/>
                <label>{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}:</label>
                @if( $project->getMetadata('member') )
                    {!! $project->getMetadata('member')->implode(', ') !!}
                @endif
                <br/>
                <label>{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}:</label>
                @if( $project->getMetadata('funding_source') )
                    {!! $project->getMetadata('funding_source')->implode(', ') !!}
                @endif
            </div>
            <div class="modal-footer">
                {{ Form::button('OK', ['class' => 'btn btn-success', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>

@if( false )
    <!-- Create Project Modal -->
    <div class="modal fade" id="create-project" tabindex="-1" role="dialog" aria-labelledby="create-project">
        {!! BootForm::open()->id('create-project-form')->action( route('project.store') )->put() !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Project</h4>
                </div>
                <div class="modal-body">
                    {!! BootForm::hidden('project_id')->id('project_id') !!}
                    {!! BootForm::text('DMP Title', 'title')->placeholder('My Research Project') !!}
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

    <!-- Edit Project Modal -->
    <div class="modal fade" id="edit-project" tabindex="-1" role="dialog" aria-labelledby="edit-project">
        {!! BootForm::open()->id('edit-project-form')->action( route('project.update') )->put() !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Project {{ $project->identifier }}</h4>
                </div>
                <div class="modal-body">
                    {!! BootForm::hidden('id')->id('id') !!}
                    {!! BootForm::text('Project ID', 'identifier')->value($project->identifier)->readonly('readonly') !!}

                @if (true)
                        @foreach( $project->metadata->load('metadata_registry') as $metadata_field )
                            <?php //var_dump($metadata_field->metadata_registry->title) ?>
                            <?php //var_dump($metadata_field->language) ?>
                            <?php //var_dump($metadata_field->content) ?>

                            <div class="form-group row container">
                                <div class="col-md-2">
                                    {!! Form::Label( $metadata_field->metadata_registry->identifier, $metadata_field->metadata_registry->name ) !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::Text( $metadata_field->metadata_registry->identifier . '[' . $metadata_field->language . ']', $metadata_field->content, array('class' => 'form-control xs') ) !!}
                                </div>
                            </div>
                        @endforeach
                    @endif

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
@endif