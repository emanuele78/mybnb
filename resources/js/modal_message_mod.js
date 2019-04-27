const HANDLE_MODULE_MESSAGE = {

    showModule: function (confirm_data, dismiss_data, confirm_callback, dimiss_callback) {
        performAction(confirm_data, dismiss_data, confirm_callback, dimiss_callback);
    }

};

function performAction(confirm_data, dismiss_data, confirm_callback, dimiss_callback) {
    let modalComponent = $('#modal_message');
    let confirmButton = $('#confirm_modal_button');
    let dismissButton = $('#dismiss_modal_button');
    //set data
    confirmButton.attr('data-action', confirm_data);
    dismissButton.attr('data-action', dismiss_data);
    //set listeners
    confirmButton.off();
    dismissButton.off();
    confirmButton.click(function () {
        modalComponent.modal('hide');
        if (confirm_callback !== null) {
            confirm_callback($(this).attr('data-action'));
        }
    });
    dismissButton.click(function () {
        if (dimiss_callback !== null) {
            dimiss_callback($(this).attr('data-action'));
        }
    });
    //show modal component
    modalComponent.modal('show');
}

export default HANDLE_MODULE_MESSAGE;