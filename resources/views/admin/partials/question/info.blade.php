<tr class="question" id="question_{{ $question->id }}" title="{{ $question->id }}">
    <td>{{ $question->order }}</td>
    <td>{{ $question->keynumber }}</td>
    @if( $question->parent_id )
        <td style="padding-left:5em">
    @else
        <td>
    @endif
    {{ $question->text }}</td>
    <td>@date( $question->created_at ) @time( $question->created_at )</td>
    <td>
        @if( $question->updated_at )
            @date( $question->updated_at ) @time( $question->updated_at )
        @endif
    </td>
    <td>
        {!! Form::open(['method' => 'GET', 'route' => ['admin.question.edit', $question->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.edit') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.edit')] )  !!}
        {!! Form::close() !!}
        &nbsp;&nbsp;
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.question.destroy', $question->id], 'style'=>'display:inline-block', 'class' => 'form-inline', 'role' => 'form']) !!}
        {!! Form::button('<i class="fa ' . trans('admin/table.icon.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-link btn-xs nopadding', 'title' => trans('admin/table.label.delete')] )  !!}
        {!! Form::close() !!}
    </td>
</tr>
@if(true)
    @foreach($question->getDescendants() as $question)
        @include('admin.partials.question.info', $question)
    @endforeach
@endif