<tr>
    <td>
        <strong>{{ $project->identifier }}</strong>
        @if( $project->isChild() )
            <br/>Parent Project: {{ $project->parent->identifier }}
        @endif
        <br/>
        @if( $project->getMetadata('title') )
            @foreach( $project->getMetadata('title') as $title )
                "{{ $title['content'] }}" ({{ strtoupper($title['language']) }})<br/>
            @endforeach
        @endif

        @if( $project->getMetadata('begin') )
            @foreach( $project->getMetadata('begin') as $begin )
                @date($begin) -
                @if( $project->getMetadata('end') )
                    @foreach( $project->getMetadata('end') as $end )
                        @date($end)
                    @endforeach
                @endif
            @endforeach
            <br/>
        @endif
    </td>
    <td>
        @if( $project->getMetadata('leader') )
            @foreach( $project->getMetadata('leader') as $leader )
                <strong>{!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}</strong><br/>
            @endforeach
        @endif
        @if( $project->getMetadata('member') )
            @foreach( $project->getMetadata('member') as $member )
                {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}<br/>
            @endforeach
        @endif
    </td>
    <td>
        {{ $project->plans_count }}
    </td>
    <td>
        @if($project->data_source)
            {{ $project->data_source->identifier }}
            @if ($project->is_prefilled)
                <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
            @else
                <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
            @endif
        @else
            <i>None</i>
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