<div class="modal fade" id="create-plan" tabindex="-1" role="dialog" aria-labelledby="create-plan">
    {!! BootForm::open()->class('bootstrap-modal-form')->action( route('plan.store') )->put() !!}
    {!! BootForm::hidden('project_id') !!}
    {!! BootForm::text('DMP Title', 'title')->placeholder('My Data Management Plan') !!}
    {!! BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id'))->placeholder('Select Template') !!}
    {!! BootForm::submit('Create')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
</div>