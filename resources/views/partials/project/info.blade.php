<tr v-show={{ $project->isRoot() ? "true" : "false" }}>
    <td>
        {{ $project->identifier }}
        @if( $project->isRoot() )
            <br/><i>Parent Project</i>
        @endif
    </td>
    <td>
        {{ $project->title }}
        Title<br/>
        Laufzeit<br/>
        Funding<br/>
        Partners<br/>
        Current Stage?<br/>
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
            ({{ $project->data_source->type }})
            &nbsp;
            @if ($project->is_prefilled)
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
            @else
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
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
@foreach ($project->children as $project)
    @include('partials.project.info', $project)
@endforeach