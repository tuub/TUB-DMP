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
                                {!! Form::Text( $metadata_field->metadata_registry->identifier, $metadata_field->content, array('class' => 'form-control xs') ) !!}
                            </div>
                        </div>
                    @endforeach
                @endif

                {!! BootForm::text('DMP Title', 'title') !!}
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