<div class="modal fade" id="modal_message" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{$modal_title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">{{$slot}}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="dismiss_modal_button" data-dismiss="modal">{{$modal_dismiss_button_text}}</button>
                <button type="button" class="btn btn-primary" id="confirm_modal_button">{{$modal_confirm_button_text}}</button>
            </div>
        </div>
    </div>
</div>