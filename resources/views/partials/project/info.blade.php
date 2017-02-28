<tr>
    <td>
        {{ $project->identifier }}
    </td>
    <td>
        {{ $project->title }}
    </td>
    <td>
        {{ $project->user->name_with_email }} + MEMBERS
    </td>
    <td>
        {{ $project->children()->count() }}
    </td>
    <td>
        {{ $project->plans()->count() }}
    </td>
    <td>
        ???
    </td>
    <td>
        Expand----
    </td>
</tr>