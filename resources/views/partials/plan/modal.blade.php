<!-- Modal -->

<div class="modal fade" id="export-option-for-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="export-option-for-{{ $plan->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Choose Export Format</h4>
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
                        <td>Exports your DMP with all pre-filled and manually provided data.</td>
                        <td>
                            <a download href='{{URL::route('export_plan', [$plan->project_number, $plan->version, 'pdf'] )}}'>Open/Download</a>
                        </td>
                    </tr>

                </table>

            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="email-option-for-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="email-option-for-{{ $plan->id }}">
    {!! Form::open(array('route' => array('email_plan'), 'method' => 'post', 'class' => 'form-inline', 'id' => 'email_plan'))  !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Send DMP via e-mail</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden( 'project_number', $plan->project_number) !!}
                    {!! Form::hidden( 'version', $plan->version) !!}
                    {!! csrf_field() !!}
                    {!! Form::label('name', 'Recipient name', array('class' => 'control-label')) !!}
                    {!! Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'John Doe')) !!}
                    {!! Form::label('email', 'Recipient e-mail', array('class' => 'control-label')) !!}
                    {!! Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'john.doe@example.org')) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Send', array('class' => 'btn btn-success' )) !!}
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>

<div class="modal fade" id="version-option-for-{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="version-option-for-{{ $plan->id }}">
    {!! Form::open(array('route' => array('version_plan'), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'version_plan'))  !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm new version</h4>
                </div>
                <div class="modal-body">
                    Are you sure that you want to create the next version of your DMP?<br/><br/>
                    <strong>Once you created version {{ $plan->version+1 }} of your DMP, you will not be able to edit the data of your current version.</strong>
                    {!! Form::hidden( 'project_number', $plan->project_number) !!}
                    {!! Form::hidden( 'version', $plan->version) !!}
                    {!! csrf_field() !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Yes', array('class' => 'btn btn-success' )) !!}
                    {!! Form::reset('No', array('class' => 'btn btn-danger', 'data-dismiss' => 'modal' )) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>