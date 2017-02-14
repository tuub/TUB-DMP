<tr>
    <td>{{ $plan->id }}</td>
    <td>{{ $plan->project_number }}</td>
    <td>{{ $plan->version }}</td>
    <td>{{ $plan->template->name }}</td>
    <td>{{ $plan->user->real_name }}</td>
    <td>{{ $plan->datasource }}</td>
    <td>{{ $plan->getQuestionAnswerPercentage() }} %</td>
    <td>@date( $plan->created_at ) @time( $plan->created_at )</td>
    <td>
        @if( $plan->updated_at )
            @date( $plan->updated_at ) @time( $plan->updated_at )
        @endif
    </td>
    <td>
        @if( $plan->prefilled_at )
            @date( $plan->prefilled_at ) @time( $plan->prefilled_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.plan.edit', $plan->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Edit', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.plan.destroy', $plan->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}
    </td>
</tr>