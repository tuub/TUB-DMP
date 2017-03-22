<tr v-show={{ $project->isRoot() ? "true" : "false" }}>
    <td>
        {{ $project->identifier }}
        @if( $project->isRoot() )
            <br/><i>Parent Project</i>
        @endif
    </td>
    <td>
        @unless( $project->getMetadata('title', 'de')->isEmpty() )
            @foreach( $project->getMetadata('title', 'de') as $title )
                {{ $title }}<br/>
            @endforeach
        @endunless

        @unless( $project->getMetadata('begin')->isEmpty() )
            @date( $project->getMetadata('begin')->first() ) -
            @unless( $project->getMetadata('end')->isEmpty() )
                @date( $project->getMetadata('end')->first() )
            @endunless
            <br/>
        @endunless
        @unless( $project->getMetadata('funding_source')->isEmpty() )
            Funded by
            {{ $project->getMetadata('funding_source')->implode(', ') }}
        @endunless
    </td>
    <td>
        {{ $project->user->name }}
        <br/>
        @unless( $project->getMetadata('members')->isEmpty() )
            @foreach( $project->getMetadata('members') as $member )
                {{ $member }}<br/>
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
        <span class="text-info">{{ $project->status }}</span>
    </td>
    <td>
        <a href="{{ route('project.show', $project->id)}}" class="show-project" data-rel="{{ $project->id }}" data-toggle="modal" data-target="#show-project-{{$project->id}}" title="Show Project"><i class="fa fa-eye"></i></a>
        <a href="{{ route('project.edit', $project->id)}}" class="edit-project" data-rel="{{ $project->id }}" data-toggle="modal" data-target="#edit-plan-{{$project->id}}" title="Edit Project"><i class="fa fa-pencil"></i></a>
    </td>
    <td>
        <a href="#" class="show-plans" data-href="{{  $project->id }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
        <a href="#" class="hide-plans" data-href="{{  $project->id }}"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
    </td>
</tr>
    <tr class="dashboard-project-plans hidden" data-content="{{  $project->id }}">
        <td colspan="8">
            @foreach ($project->plans()->ordered()->get() as $plan)
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