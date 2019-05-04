/**
 * Exported object
 * @type {{showInfoModal: HANDLE_MODULE_MESSAGE.showInfoModal}}
 */
const HANDLE_MODULE_MESSAGE = {

    showInfoModal: function (confirm_callback) {
        showInfoWindow(confirm_callback);
    }

};

/**
 * Show a modal window with only one button
 * @param confirm_callback
 */
function showInfoWindow(confirm_callback) {
    let modalComponent = $('#modal_message');
    let confirmButton = $('#confirm_modal_button');
    //set listeners
    confirmButton.off();
    confirmButton.click(function () {
        modalComponent.modal('hide');
        if (confirm_callback !== null) {
            confirm_callback();
        }
    });
    //show modal component
    modalComponent.modal('show');
}

/**
 * default export
 */
export default HANDLE_MODULE_MESSAGE;