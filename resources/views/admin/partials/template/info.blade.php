<tr>
    <td>{{ $template->id }}</td>
    <td>{{ $template->name }}</td>
    <td>{{ $template->institution->name }}</td>
    <td>{{ $template->is_active }}</td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.template.edit', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Edit', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.template.destroy', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}
    </td>
</tr>