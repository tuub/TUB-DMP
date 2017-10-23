<tr title="{{ $template->id  }}">
    <td>{{ $template->name }}</td>
    <td>{{ $template->institution->name }}</td>
    <td>{{ $template->sections()->count() }}</td>
    <td>{{ $template->surveys()->count() }}</td>
    <td>{{ $template->is_active ? trans('admin/table.value.true') : trans('admin/table.value.false') }}</td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.template.edit', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.template.destroy', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}

        {!! HTML::linkRoute('admin.template.sections.index', trans('admin/table.label.edit') . ' Sections', $template, ['class' => 'edit-relation']) !!}
    </td>
</tr>