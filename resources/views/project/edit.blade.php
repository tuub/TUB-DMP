
<!-- Modal -->

<div class="modal fade" id="edit-project" tabindex="-1" role="dialog" aria-labelledby="edit-project">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title">Project Metadata {{ $project->identifier }}</h1>
            </div>
            <div class="modal-body">
                {!! BootForm::open()->class('')->action( route('project.update', $project->id) )->put() !!}
                {!! BootForm::bind($project) !!}
                {!! BootForm::text('ID', 'id') !!}
                {!! BootForm::text('DMP Title', 'title')->helpBlock('A good title would help.') !!}
                {{-- BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) --}}

                @foreach( $project->metadata_fields as $metadata_field )
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label( $metadata_field->identifier, $metadata_field->name ) !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text( $metadata_field->identifier, $project->title, array('class' => 'form-control xs') ) !!}
                            <span class="help-block {{ ($errors->first($metadata_field->identifier) ? 'form-error' : '') }}">{{ $errors->first($metadata_field->identifier) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default" data-dismiss="modal">OK</a>
                {!! BootForm::submit('Save')->class('btn btn-success') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
</div>