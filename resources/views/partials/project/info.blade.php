<tr v-show={{ $project->isRoot() ? "true" : "false" }}>
    <td>
        {{ $project->identifier }}
        @if( $project->isRoot() )
            <br/><i>Parent Project</i>
        @endif
    </td>
    <td>
        {{ $project->title  }}
        @foreach( $project->metadata as $metadata )
            {{ $metadata->metadata_field->name }}
            :
            {{ $metadata->content }}
            <br/>
        @endforeach
    </td>
    <td>
        {{ $project->user->name_with_email }}
        <br/>
        MEMBERS
    </td>
    <td>
        {{ $project->plans()->count() }}
    </td>
    <td>
        {{ $project->children()->count() }}
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
        DATE COMPARE:
        Running
    </td>
    <td>
        @if( $project->children()->count() )
            <a href="#" data-href="{{  $project->id }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
            <a href="#" data-href="{{  $project->id }}"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
        @endif
    </td>
</tr>
@if( $project->plans()->count() > 0 )
    <tr>
        <td colspan="8">
            @foreach ($project->plans as $plan)
                @include('partials.plan.info', $plan)
            @endforeach
        </td>
    </tr>
@endif

@foreach ($project->children as $project)
    @include('partials.project.info', $project)
@endforeach