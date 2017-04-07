<label>{{ $label }}</label>
@if( $values )
    @foreach( $values as $value )
        <div class="form-group input-with-language" data-rel="{{ $loop->index }}">
            <div class="col-md-18">
                {!! Form::text($name . '[' . $loop->index . '][content]', $value['content'], ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::select($name . '[' . $loop->index . '][language]', ['de' => 'DE', 'en' => 'EN'], $value['language'], ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2">
                @if( $loop->last )
                    {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                @else
                    {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                @endif
            </div>
        </div>
    @endforeach
@else
    <div class="form-group input-with-language" data-rel="0">
        <div class="col-md-18">
            {!! Form::text($name . '[0][content]', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::select($name . '[[0][language]', ['de' => 'DE', 'en' => 'EN'], null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-2">
            {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
        </div>
    </div>
@endif