<tr title="{{ $plan->id }}">
    <td>{{ $plan->title }}</td>
    <td>{{ $plan->version }}</td>
    <td>{{ $plan->survey->template->name }}</td>
    <td>{{ $plan->survey->completion }} %</td>
    <td>{{ $plan->is_snapshot ? trans('admin/table.value.true') : trans('admin/table.value.false') }}</td>
    <td>@date( $plan->created_at ) @time( $plan->created_at )</td>
    <td>
        @if( $plan->updated_at )
            @date( $plan->updated_at ) @time( $plan->updated_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.plan.edit', $plan->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'GET', 'route' => ['plan.export', $plan->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.export') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.export')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'GET', 'route' => ['admin.plan.survey.index', $plan], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.show') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.show')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.plan.destroy', $plan->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}
    </td>
</tr>
