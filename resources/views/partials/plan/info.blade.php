<div class="dashboard-plan-info">
    <table>
        <tr>
            <td class="bullet">
                <i class="fa fa-file-text-o fa-1x"></i>
            </td>
            <td class="title">
                {{ $plan->title }},
                Version {{ $plan->version }}
            </td>
        </tr>
        <tr>
            <td class="metadata" colspan="2">
                <strong>Owner:</strong> {{ $plan->project->user->real_name }}<br/>
                <strong>Template:</strong> {{ $plan->template->name }}<br/>
            </td>
            <td class="timestamps">
                <strong>Created:</strong> @date( $plan->created_at ) at @time( $plan->created_at )<br/>
                <strong>Updated:</strong> @date( $plan->updated_at ) at @time( $plan->updated_at )
            </td>
            <td class="status">
                @if( $plan->is_final )
                    <i class="fa fa-check-square-o fa-1x" aria-hidden="true"></i><span class="hidden-xs"></span>
                @else
                    {{ $plan->getQuestionAnswerPercentage() }}&nbsp;%
                    <!--(<small>{{ $plan->getAnswerCount() }} of {{ $plan->getQuestionCount() }} answered</small>)-->
                @endif
            </td>
            <td class="tools">
                @if( !$plan->is_final )
                    <a href="{{ URL::route('edit_plan', [$plan->project->identifier, $plan->version]) }}" class="btn btn-default btn-xs" title="Edit"><i class="fa fa-pencil"></i><span class="hidden-xs"> Edit</span></a>
                @endif
                <a href="{{ URL::route('show_plan', [$plan->id]) }}" class="btn btn-default btn-xs" title="View"><i class="fa fa-eye"></i><span class="hidden-xs"> View</span></a>
                <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#email-option-for-{{ $plan->id }}" title="Email"><i class="fa fa-envelope"></i><span class="hidden-xs"> Email</span></a>
                <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#export-option-for-{{ $plan->id }}" title="Export"><i class="fa fa-download"></i><span class="hidden-xs"> Export</span></a>
                @if( $plan->is_final )
                    @if( !$plan->hasVersion($plan->project->identifier, $plan->version+1) )
                        <a href="{{ URL::route('toggle_plan', [$plan->project->identifier, $plan->version]) }}" class="btn btn-default btn-xs" title="Reopen"><i class="fa fa-unlock"></i><span class="hidden-xs"> Reopen</span></a>
                        <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#version-option-for-{{ $plan->id }}" title="Make new Version {{ $plan->version+1 }}"><i class="fa fa-forward"></i><span class="hidden-xs"> Create version {{ $plan->version+1 }}</span></a>
                    @else
                        This DMP is finished and already has a version {{ $plan->version+1 }}.
                    @endif
                @else
                    <a href="{{ URL::route('toggle_plan', [$plan->project->identifier, $plan->version]) }}" class="btn btn-default btn-xs" title="Finish"><i class="fa fa-lock"></i><span class="hidden-xs"> Finish DMP</span></a>
                @endif
            </td>
        </tr>
    </table>
</div>

@include('partials.plan.modal', $plan)