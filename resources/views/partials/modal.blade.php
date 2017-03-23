
<!-- TODO: Convert to BootForm -->
<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="feedback">
    {!! Form::open(array('route' => array('feedback'), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'feedback'))  !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Feedback Form</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    {!! Form::label('name', 'Name', array('class' => 'control-label')) !!}
                    {!! Form::text('name', Auth::user()->name, array('class' => 'form-control', 'placeholder' => 'John Doe')) !!}
                    {!! Form::label('email', 'Email', array('class' => 'control-label')) !!}
                    {!! Form::text('email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'john.doe@example.org')) !!}
                    <div class="row form-group">
                        {!! Form::label('message', 'Your Feedback message', array('class' => 'control-label col-md-4')) !!}
                        <div class="col-md-12">
                            {!! Form::textarea('message', '', array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Your feedback message')) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Send', array('class' => 'btn btn-success' )) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
</div>
