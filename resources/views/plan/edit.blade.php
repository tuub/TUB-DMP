<!-- Modal -->

<div class="modal fade" id="edit-plan" tabindex="-1" role="dialog" aria-labelledby="edit-plan">
    {!! BootForm::open()->class('')->action( route('plan.update', $plan->id) )->put() !!}
    {!! BootForm::bind($plan) !!}
    {!! BootForm::text('ID', 'id') !!}
    {!! BootForm::text('DMP Title', 'title')->helpBlock('A good title would help.') !!}
    {{-- BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) --}}
    {!! BootForm::text('DMP Version', 'version') !!}
    {!! BootForm::submit('Save')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
</div>