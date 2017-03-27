<tr v-show={{ $project->isRoot() ? "true" : "false" }}>
    <td>
        {{ $project->identifier }}
        @if( $project->isRoot() )
            <br/><i>Parent Project</i>
        @endif
    </td>
    <td>
        @unless( $project->getMetadata('title')->isEmpty() )
            @foreach( $project->getMetadata('title') as $title )
                {{ App\ProjectMetadata::formatForOutput($title, $project->getMetadataContentType('title')) }}
            @endforeach
            <br/>
        @endunless

        @unless( $project->getMetadata('begin')->isEmpty() )
            @foreach( $project->getMetadata('begin') as $begin )
                @date( App\ProjectMetadata::formatForOutput($begin, $project->getMetadataContentType('begin')) )
                -
            @endforeach
            @unless( $project->getMetadata('end')->isEmpty() )
                @foreach( $project->getMetadata('end') as $end )
                    @date( App\ProjectMetadata::formatForOutput($end, $project->getMetadataContentType('end')) )
                @endforeach
            @endunless
            <br/>
        @endunless

        @unless( $project->getMetadata('funding_source')->isEmpty() )
            Funded by
            @foreach( $project->getMetadata('funding_source') as $funding_source )
                {{ App\ProjectMetadata::formatForOutput($funding_source, $project->getMetadataContentType('funding_source')) }}
            @endforeach
        @endunless
    </td>
    <td>
        {{ $project->user->name }}
        <br/>
        @unless( $project->getMetadata('members')->isEmpty() )
            @foreach( $project->getMetadata('members') as $member )
                {{ App\ProjectMetadata::formatForOutput($member, $project->getMetadataContentType('members')) }}
            @endforeach
        @endunless
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
            &nbsp;
            @if ($project->is_prefilled)
                <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
            @else
                <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
            @endif
        @endif
    </td>
    <td>
        @if( false )
        <span class="text-info">{{ $project->status }}</span>
            @endif
    </td>
    <td>
        <a href="{{ route('project.show', $project->id)}}" class="show-project btn btn-default btn-xs" data-rel="{{ $project->id }}" data-toggle="modal" data-target="#show-project-{{$project->id}}" title="Show Project">
            <i class="fa fa-eye"></i></a><!--<span class="hidden-sm hidden-xs"> Show</span>-->
        </a>
        <a href="{{ route('project.edit', $project->id)}}" class="edit-project btn btn-default btn-xs" data-rel="{{ $project->id }}" data-toggle="modal" data-target="#edit-project-{{$project->id}}" title="Edit Project">
            <i class="fa fa-pencil"></i></a><!--<span class="hidden-sm hidden-xs"> Edit</span>-->
        </a>
    </td>
    <td>
        <a href="#" class="show-plans btn btn-default btn-xs" data-href="{{  $project->id }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="#" class="hide-plans btn btn-default btn-xs" data-href="{{  $project->id }}"><i class="fa fa-minus" aria-hidden="true"></i></a>
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
@endforeach