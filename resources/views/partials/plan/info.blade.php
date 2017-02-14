<tr>
    <td>
        <a href="{{ URL::route('show_plan', [$plan->project_number, $plan->version]) }}">{{ $plan->project_number }}</a>

        <div class="plan-status">
            @if( $plan->is_final )
                <i class="fa fa-check fa-2x"></i><span class="hidden-xs"></span>
            @else
                {{ $plan->getQuestionAnswerPercentage() }} %
                @if( false )
                    Status: <span style="background-color: {{ $plan->getColoredQuestionAnswerPercentage() }}">{{ $plan->getQuestionAnswerPercentage() }} %</span>
                    <br/>{{ $plan->getAnswerCount() }} / {{ $plan->getQuestionCount() }}
                @endif
            @endif
        </div>
    </td>
    <td class="text-center">
        {{ $plan->version }}
    </td>
    <td>
        <strong>Template:</strong> {{ $plan->template->name }}<br/>
        <strong>Status:</strong> {{ $plan->getAnswerCount() }} of {{ $plan->getQuestionCount() }} answered<br/>
        <strong>Created:</strong> @date( $plan->created_at ) at @time( $plan->created_at )<br/>
        @if( $plan->prefilled_at == $plan->updated_at )
            <strong>Auto Import Date:</strong> @date( $plan->prefilled_at ) at @time( $plan->prefilled_at )<br/>
        @else
            @if( $plan->prefilled_at )
                <strong>Auto Import Date:</strong> @date( $plan->prefilled_at ) at @time( $plan->prefilled_at )<br/>
            @endif
            @if( $plan->updated_at != $plan->created_at )
                <strong>Modified:</strong> @date( $plan->updated_at ) at @time( $plan->updated_at )<br/>
            @endif
        @endif
        <strong>Owner:</strong> {{ $plan->user->real_name }}
    </td>
    <td>
        <div>
            @if( !$plan->is_final )
                <a href="{{ URL::route('edit_plan', [$plan->project_number, $plan->version]) }}" class="btn btn-default btn-xs" title="Edit"><i class="fa fa-pencil"></i><span class="hidden-xs"> Edit</span></a>
            @endif
            <a href="{{ URL::route('show_plan', [$plan->project_number, $plan->version]) }}" class="btn btn-default btn-xs" title="View"><i class="fa fa-eye"></i><span class="hidden-xs"> View</span></a>
            <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#email-option-for-{{ $plan->id }}" title="Email"><i class="fa fa-envelope"></i><span class="hidden-xs"> Email</span></a>
            <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#export-option-for-{{ $plan->id }}" title="Export"><i class="fa fa-download"></i><span class="hidden-xs"> Export</span></a>
            <br/><br/>
            @if( $plan->is_final )
                @if( !$plan->hasVersion($plan->project_number, $plan->version+1) )
                    <a href="{{ URL::route('toggle_plan', [$plan->project_number, $plan->version]) }}" class="btn btn-default btn-xs" title="Reopen"><i class="fa fa-unlock"></i><span class="hidden-xs"> Reopen</span></a>
                    <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#version-option-for-{{ $plan->id }}" title="Make new Version {{ $plan->version+1 }}"><i class="fa fa-forward"></i><span class="hidden-xs"> Create version {{ $plan->version+1 }}</span></a>
                @else
                    This DMP is finished and already has a version {{ $plan->version+1 }}.
                @endif
            @else
                <a href="{{ URL::route('toggle_plan', [$plan->project_number, $plan->version]) }}" class="btn btn-default btn-xs" title="Finish"><i class="fa fa-lock"></i><span class="hidden-xs"> Finish DMP</span></a> and create version {{ $plan->version+1 }}
            @endif
        </div>
        @include('partials.plan.modal', $plan)
    </td>
</tr>