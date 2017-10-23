<tr class="section" id="section_{{ $section->id }}" title="{{ $section->id }}">
    <td>{{ $section->keynumber }}</td>
    <td>{{ $section->name }}</td>
    <td>{{ $section->questions_count }}</td>
    <td>@date( $section->created_at ) @time( $section->created_at )</td>
    <td>
        @if( $section->updated_at )
            @date( $section->updated_at ) @time( $section->updated_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.section.edit', $section->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.section.destroy', $section->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}

        {!! HTML::linkRoute('admin.section.questions.index', trans('admin/table.label.edit') . ' Questions', $section, ['class' => 'edit-relation']) !!}
    </td>
</tr>