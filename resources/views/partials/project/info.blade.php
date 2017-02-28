<tr>
    <td>
        {{ $project->identifier }}
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
            + STATUS
        @endif
    </td>
    <td>
        DATE COMPARE:
        Running
    </td>
    <td>
        Expand----
    </td>
</tr>