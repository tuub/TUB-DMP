<tr>
    @if( $question->parent_id )
        <td style="padding-left:5em">
    @else
        <td>
    @endif
    {{ $question->text }}</td>
    <td style="width: 120px;">{{ $question->template->name }}</td>
    <td>{{ $question->keynumber }}</td>
    <td>{{ $question->order }}</td>
    <td>{{ $question->id }}</td>
    <td>@date( $question->created_at ) @time( $question->created_at )</td>
    <td>
        @if( $question->updated_at )
            @date( $question->updated_at ) @time( $question->updated_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.question.edit', $question->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Edit', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}

        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.question.destroy', $question->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-link nopadding']) !!}
        {!! Form::close() !!}
    </td>
</tr>