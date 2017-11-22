<!-- Export Plan Modal -->
<div class="modal fade" id="export-plan-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="export-plan-{{ $plan->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('plan.export.title') }}</h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ trans('plan.export.description') }}
                </p>
                <table class="table">
                    <tr>
                        <th>Format</th>
                        <th>Description</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td>{{ trans('plan.export.format.pdf.label') }}</td>
                        <td>{{ trans('plan.export.format.pdf.description') }}</td>
                        <td>
                            <!-- download -->
                            <a href="{{URL::route('plan.export', ['id' => $plan->id] )}}" target="_blank">{{ trans('plan.export.format.pdf.link') }}</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                {!! Form::button(trans('plan.export.button.cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
            </div>
        </div>
    </div>
</div>

<!-- Delete Plan Modal -->
<div class="modal fade" id="delete-plan-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="delete-plan-{{ $plan->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! BootForm::open()->class('delete-plan-form')->role('form')->data(['rel' => $plan->id])->action( route('plan.destroy') )->delete() !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('plan.delete.title') }} {{ $plan->id }}</h4>
            </div>
            <div class="modal-body">
                {!! BootForm::hidden('id')->id('id')->value($plan->id) !!}
                {{ trans('plan.delete.description') }}
            </div>
            <div class="modal-footer">
                {!! BootForm::button(trans('plan.delete.button.cancel'))->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit(trans('plan.delete.button.submit'))->class('btn btn-success') !!}
            </div>
            {!! BootForm::close() !!}
        </div>
    </div>
</div>