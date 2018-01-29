<tr title="{{ $project->id }}">

    @if ($project->isChild())
        <td style="padding-left:{!! ($project->getLevel()+1)*0.9 !!}em">
    @else
        <td>
    @endif

    @if ($project->isRoot())
        <span class="fa fa-cubes"></span>
    @endif
    @if ($project->isChild())
            <span class="fa fa-child"></span>
    @endif
    {{ $project->identifier }}

    </td>

    <td>{{ $project->contact_email ? HTML::mailto($project->contact_email) : trans('admin/table.value.null') }}</td>
    <td>
        @if ($project->is_active)
            <span class="fa fa-circle" style="color:green;"></span>
        @else
            <span class="fa fa-circle" style="color:red;"></span>
        @endif
    </td>
    <td>{{ $project->plans_count }}</td>
    <td>
        @if( $project->data_source_id )
            {{ $project->data_source->name }}
            :
            @if( $project->imported )
                @date( $project->imported_at ) @time( $project->imported_at )
            @else
                {{ trans('admin/table.value.null') }}
            @endif
        @else
            {{ trans('admin/table.value.null') }}
        @endif
    </td>
    <td>
        @if( $project->updated_at )
            @date( $project->updated_at ) @time( $project->updated_at )
        @else
            @date( $project->created_at ) @time( $project->created_at )
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
@foreach($project->getImmediateDescendants() as $project)
    @include('admin.partials.project.info', $project)
@endforeach