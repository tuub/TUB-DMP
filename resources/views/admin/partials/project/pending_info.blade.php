<tr title="{{ $project->id }}">

    <td>{{ $project->identifier }}</td>
    <td>{{ $project->user->email ? HTML::mailto($project->user->email) : trans('admin/table.value.null') }}</td>
    <td>{{ $project->contact_email ? HTML::mailto($project->contact_email) : trans('admin/table.value.null') }}</td>
    <td>@date( $project->created_at ) @time( $project->created_at )</td>
    <td>
        {!! Form::open(['method' => 'POST', 'route' => ['admin.project.approve', $project->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button(trans('admin/table.label.approve'), ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.approve')] )  !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'POST', 'route' => ['admin.project.reject', $project->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button(trans('admin/table.label.reject'), ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.reject')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.project.destroy', $project->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}
    </td>
</tr>
@foreach($project->getImmediateDescendants() as $project)
    @include('admin.partials.project.info', $project)
@endforeach