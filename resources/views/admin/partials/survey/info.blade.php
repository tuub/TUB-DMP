<tr>
    <td>
        <div class="question-text">
            {!! $question !!}
        </div>
    </td>
    <td>
        <div class="answer-text">
            {!! empty($answer) ? trans('admin/table.value.null') : $answer !!}
        </div>
    </td>
    <td>&nbsp;</td>
</tr>