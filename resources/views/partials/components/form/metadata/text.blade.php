<label>{{ $label }}</label>
@if( $values )
    @foreach( $values as $value )
        <div class="form-group row" data-rel="{{ $loop->index }}">
            <div class="col-md-21">
                {!! Form::text($name . '[' . $loop->index . ']', $value, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                @if( $is_multiple )
                    @if( $loop->last )
                        {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                        {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                    @else
                        {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@else
    <div class="form-group row" data-rel="0">
        <div class="col-md-21">
            {!! Form::text($name . '[0]', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
            @if( $is_multiple )
                {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
            @endif
        </div>
    </div>
@endif