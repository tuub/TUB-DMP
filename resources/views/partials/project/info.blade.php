<tr>
    <td>
        {{ $project->identifier }}
        @if( $project->isRoot() )
            <br/><i>Parent Project</i>
        @endif
    </td>
    <td>
        @if( $project->getMetadata('title') and $project->getMetadata('title')->count() )
            @foreach( $project->getMetadata('title') as $title )
                <label>{{ strtoupper($title['language']) }}:</label> {{ $title['content'] }}<br/>
            @endforeach
        @endif

        @if( $project->getMetadata('begin') and $project->getMetadata('begin')->count() )
            <label>Duration:</label>
            @foreach( $project->getMetadata('begin') as $begin )
                @date($begin) -
                @if( $project->getMetadata('end') and $project->getMetadata('end')->count() )
                    @foreach( $project->getMetadata('end') as $end )
                        @date($end)
                    @endforeach
                @endif
            @endforeach
        @endif
        <br/>
        @if( $project->getMetadata('funding_source') and $project->getMetadata('funding_source')->count() )
            <label>Funded by:</label>
            {{ $project->getMetadata('funding_source')->implode(', ') }}
        @endif
    </td>
    <td>
        @if( $project->getMetadata('member') and $project->getMetadata('member')->count() )
            @foreach( $project->getMetadata('member') as $member )
                {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}<br/>
            @endforeach
        @endif
    </td>
    <td>
        {{ $project->plans_count }}
    </td>
    <td>
        {{ $project->children_count }}
    </td>
    <td>
        @if($project->data_source)
            {{ $project->data_source->identifier }}
            @if ($project->is_prefilled)
                <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
            @else
                <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
            @endif
        @endif
    </td>
    <td>
        <span class="text-info">{{ $project->status }}</span>
    </td>
    <td>
        <a href="{{ route('project.show', $project->id)}}" class="show-project btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#show-project-{{$project->id}}" title="Show Project">
            <i class="fa fa-eye"></i></a><!--<span class="hidden-sm hidden-xs"> Show</span>-->
        </a>
        <a href="{{ route('project.edit', $project->id)}}" class="edit-project btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#edit-project-{{$project->id}}" title="Edit Project">
            <i class="fa fa-pencil"></i></a><!--<span class="hidden-sm hidden-xs"> Edit</span>-->
        </a>
    </td>
    <td>
        <a href="#" class="toggle-plans btn btn-default btn-xs" data-href="{{  $project->id }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
    </td>
</tr>
<tr class="dashboard-project-plans hidden" data-content="{{  $project->id }}">
    <td colspan="8">
        @foreach ($project->plans as $plan)
            @include('partials.plan.info', $plan)
        @endforeach

        <div class="dashboard-plan-create-new container col-md-24 col-sm-24 col-xs-24 text-center">
            <div class="col-md-24">
                <a href="#" class="create-plan btn btn-default btn-lg" data-toggle="modal" data-target="#create-plan" data-rel="{{ $project->id }}"title="Create new DMP">
                    <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">&nbsp;&nbsp;&nbsp;Create DMP</span>
                </a>
            </div>
        </div>
    </td>
</tr>

@foreach ($project->children as $project)
    @include('partials.project.info', $project)
    @include('partials.project.modal', $project)
@endforeach