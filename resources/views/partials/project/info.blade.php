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
        @if( $project->children_count )
            <a href="#" class="show-plans" data-href="{{  $project->id }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
            <a href="#" class="hide-plans" data-href="{{  $project->id }}"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
        @endif
    </td>
</tr>
@if( $project->plans_count > 0 )
    <tr class="hidden" data-content="{{  $project->id }}">
        <td colspan="8">
            @foreach ($project->plans as $plan)
                @include('partials.plan.info', $plan)
            @endforeach

            <div class="dashboard-plan-create-new container col-md-24 col-sm-24 col-xs-24 text-center">
                <div class="col-md-24">
                    <a href="#" class="bootstrap-modal-form-open btn btn-default btn-lg" data-toggle="modal" data-target="#create-plan" title="Create new DMP">
                        <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">&nbsp;&nbsp;&nbsp;Create DMP</span>
                    </a>
                </div>
            </div>

        </td>
    </tr>
@endif

@foreach ($project->children as $project)
    @include('partials.project.info', $project)
@endforeach