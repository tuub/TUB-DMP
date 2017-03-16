<!-- Question Info Modal -->
<div class="modal fade" id="show-question-info-{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="show-question-info">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Information</h4>
            </div>
            <div class="modal-body">
                @if( $question->guidance )
                    <h5>Guidance</h5>
                    {!! $question->guidance !!}
                @endif
                @if( $question->comment )
                    <h5>Comment</h5>
                    {!! $question->comment !!}
                @endif
                @if( $question->hint )
                    <h5>More Information</h5>
                    {!! $question->hint !!}
                @endif
                @if( $question->reference )
                    <h5>Reference</h5>
                    {!! $question->reference !!}
                @endif
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success" data-dismiss="modal">OK</a>
            </div>
        </div>
    </div>
</div>