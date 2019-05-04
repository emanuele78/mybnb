/**
 * Exported object
 * @type {{showActionModal: HANDLE_MODULE_MESSAGE.showActionModal}}
 */
const HANDLE_MODULE_MESSAGE = {

    showActionModal: function (confirm_data, dismiss_data, confirm_callback, dimiss_callback) {
        showActionWindow(confirm_data, dismiss_data, confirm_callback, dimiss_callback);
    }

};

/**
 * Show a modal window with 2 buttons
 * @param confirm_data
 * @param dismiss_data
 * @param confirm_callback
 * @param dimiss_callback
 */
function showActionWindow(confirm_data, dismiss_data, confirm_callback, dimiss_callback) {
    let modalComponent = $('#modal_message');
    let confirmButton = $('#confirm_modal_button');
    let dismissButton = $('#dismiss_modal_button');
    //set listeners
    confirmButton.off();
    dismissButton.off();
    confirmButton.click(function () {
        modalComponent.modal('hide');
        if (confirm_callback != null) {
            confirm_callback(confirm_data);
        }
    });
    dismissButton.click(function () {
        if (dimiss_callback != null) {
            dimiss_callback(dismiss_data);
        }
    });
    //show modal component
    modalComponent.modal('show');
}

/**
 * default export
 */
export default HANDLE_MODULE_MESSAGE;