<tr>
    <td>{{ $section->id }}</td>
    <td>{{ $section->name }}</td>
    <td>{{ $section->template->name }}</td>
    <td>{{ $section->keynumber }}</td>
    <td>{{ $section->order }}</td>
    <td>@date( $section->created_at ) @time( $section->created_at )</td>
    <td>
        @if( $section->updated_at )
            @date( $section->updated_at ) @time( $section->updated_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.section.edit', $section->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Edit', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.section.destroy', $section->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}
    </td>
</tr>