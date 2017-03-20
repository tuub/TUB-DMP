<style>

    div.modal-body {
        font-weight: normal !important;
    }

    h1.modal-title {
        font-size: 18px;
    }

    div.modal-body h2 {
        font-weight: bold;
        font-size: 14px;
    }

    div.modal-body ul {
        padding-left: 25px;
    }


</style>



<!-- Question Info Modal -->
<div class="modal fade" id="show-question-info-{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="show-question-info">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title">Information</h1>
            </div>
            <div class="modal-body">
                @if( $question->guidance )
                    <h2>Guidance</h2>
                    {!! $question->guidance !!}
                @endif
                @if( $question->comment )
                    <h2>Comment</h2>
                    {!! $question->comment !!}
                @endif
                @if( $question->hint )
                    <h2>More Information</h2>
                    {!! $question->hint !!}
                @endif
                @if( $question->reference )
                    <h2>Reference</h2>
                    {!! $question->reference !!}
                @endif
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success" data-dismiss="modal">OK</a>
            </div>
        </div>
    </div>
</div>