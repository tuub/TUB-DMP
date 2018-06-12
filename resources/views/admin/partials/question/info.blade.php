<tr class="question" id="{{ $question->getLevel() }}_{{ $question->id }}" title="{{ $question->id }}">
    @if( $question->parent_id )
        <td style="padding-left:{!! ($question->getLevel()+1)*1.2 !!}em">
    @else
        <td>
    @endif
        {% $question->getQuestionText() %}
    </td>
    <td class="text-center">{!! $question->guidance ? trans('admin/table.value.true') : '' !!}</td>
    <td class="text-center">{!! $question->default ? trans('admin/table.value.true'): '' !!}</td>
    <td class="text-center">{{ $question->answers()->count() }}</td>
    <td>@date( $question->created_at ) @time( $question->created_at )</td>
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
@foreach($question->getImmediateDescendants() as $question)
    @include('admin.partials.question.info', $question)
@endforeach