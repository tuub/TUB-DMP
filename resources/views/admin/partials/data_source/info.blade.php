<tr title="{{ $data_source->id }}">
    <td>{{ $data_source->name }}</td>
    <td>{{ $data_source->identifier }}</td>
    <td>{{ $data_source->type }}</td>
    <td>{{ $data_source->description }}</td>
    <td>{{ $data_source->uri }}</td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.data_source.edit', $data_source->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.data_source.destroy', $data_source->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}
    </td>
</tr>