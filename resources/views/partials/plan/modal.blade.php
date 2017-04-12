<!-- Export Plan Modal -->
<div class="modal fade" id="export-plan-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="export-plan-{{ $plan->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Choose Export Format for {{ $plan->title }}</h4>
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
                        <td>Exports your DMP with all automatically and manually provided data.</td>
                        <td>
                            <!-- download -->
                            <a href='{{URL::route('plan.export', ['id' => $plan->id] )}}'>Open/Download</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                {!! Form::button('OK', ['class' => 'btn btn-success', 'data-dismiss' => 'modal']) !!}
            </div>
        </div>
    </div>
</div>