<tr>
    <td>{{ $project->id }}</td>
    <td>{{ $project->identifier }}
        @if($project->children()->count() > 0)
            PARENT
        @endif
    </td>
    <td>{{ $project->user->real_name }} &lt;{{ $project->user->email }}&gt;</td>
    <td>{{ $project->plans()->count() }}</td>
    <td>
        {{ $project->children()->count() }}
        @if( $project->children()->count() > 0 )
            {!! Form::button('Show', ['class' => 'btn btn-xs']) !!}
        @endif
    </td>
    <td>
        @if( $project->data_source_id )
            {{ $project->data_source->name }}
        @else
            None
        @endif
    </td>
    <td>
        @if( $project->is_prefilled )
            @date( $project->prefilled_at ) @time( $project->prefilled_at )
        @else
            Never
        @endif
    </td>
    <td>@date( $project->created_at ) @time( $project->created_at )</td>
    <td>
        @if( $project->updated_at )
            @date( $project->updated_at ) @time( $project->updated_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.project.edit', $project->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Edit', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.project.destroy', $project->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}
    </td>
</tr>