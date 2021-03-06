@if($template->is_active)
    <tr title="{{ $template->id }}">
@else
    <tr title="{{ $template->id }}" class="inactive">
@endif
    <td>{{ $template->name }}</td>
    <td>

        @if($template->logo_file)
            {{ HTML::image($template->getLogoFile('header'), $template->logo_file, ['style' => 'height: 20px;']) }}
        @endif
    </td>
    <td class="text-center">{{ $template->sections()->count() }}</td>
    <td class="text-center">{{ $template->surveys()->count() }}</td>
    <td class="text-center">{!! $template->is_active ? trans('admin/table.value.true') : ''  !!}</td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.template.edit', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.template.destroy', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'GET', 'route' => ['admin.template.copy', $template->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.copy') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.copy')] )  !!}
        {!! Form::close() !!}

        {!! HTML::linkRoute('admin.template.sections.index', trans('admin/table.label.edit') . ' Sections', $template, ['class' => 'edit-relation']) !!}
    </td>
</tr>