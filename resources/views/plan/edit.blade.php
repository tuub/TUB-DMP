<!-- Modal -->

<div class="modal fade" id="edit-plan-{{$plan->id}}" tabindex="-1" role="dialog" aria-labelledby="edit-plan">
    {!! BootForm::open()->class('bootstrap-modal-form')->action( route('plan.update', $plan->id) )->put() !!}
    {!! BootForm::bind($plan) !!}
    {!! BootForm::hidden('project_id') !!}
    {!! BootForm::text('DMP Title', 'title') !!}
    {!! BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) !!}
    {!! BootForm::submit('Save')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
</div>