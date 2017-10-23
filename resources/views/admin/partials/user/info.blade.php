<tr title="{{ $user->id }}">
    <td>{{ $user->tub_om ? $user->tub_om : trans('admin/table.value.null') }}</td>
    <td>{{ $user->email ? Html::mailto($user->email) : trans('admin/table.value.null') }}</td>
    <td>{{ $user->projects_count }}</td>
    <td>{{ $user->is_admin ? trans('admin/table.value.true') : trans('admin/table.value.false') }}</td>
    <td>{{ $user->is_active ? trans('admin/table.value.true') : trans('admin/table.value.false') }}</td>
    <td>
        @if( $user->last_login )
            @date( $user->last_login ) @time( $user->last_login )
        @else
            {{ trans('admin/table.value.null') }}
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.user.edit', $user->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.user.destroy', $user->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}

        {!! HTML::linkRoute('admin.user.projects.index', trans('admin/table.label.edit') . ' Projects', $user, ['class' => 'edit-relation']) !!}
    </td>
</tr>