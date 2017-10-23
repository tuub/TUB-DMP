<tr title="{{ $project->id }}">
    <td>{{ $project->identifier }}
        @if($project->children()->count() > 0)
            PARENT
        @endif
    </td>
    <td>{{ $project->contact_email ? HTML::mailto($project->contact_email) : trans('admin/table.value.null') }}</td>
    <td>{{ $project->plans_count }}</td>
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
            {{ trans('admin/table.value.null') }}
        @endif
    </td>
    <td>
        @if( $project->imported )
            @date( $project->imported_at ) @time( $project->imported_at )
        @else
            {{ trans('admin/table.value.null') }}
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
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.project.destroy', $project->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}

        {!! HTML::linkRoute('admin.project.plans.index', trans('admin/table.label.edit') . ' Plans', $project, ['class' => 'edit-relation']) !!}
    </td>
</tr>