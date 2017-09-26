<tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->tub_om }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->plans_count }}</td>
    <td>{{ $user->is_admin }}</td>
    <td>{{ $user->is_active }}</td>
    <td>
        @if( $user->last_login )
            @date( $user->last_login ) @time( $user->last_login )
        @else
            N/A
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.user.edit', $user->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Edit', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.user.destroy', $user->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}
    </td>
</tr>