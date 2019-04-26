import PROJECT_MODULE from "./app";

/**
 * Exported object
 *
 * @type {{send: HANDLE_MESSAGE.send}}
 */
const HANDLE_MESSAGE = {

    send: function (apartment, message, token, callback) {
        performRequest(apartment, message, token, callback);
    }
};

/**
 * Perform the request to send a message
 * @param apartment
 * @param message
 * @param token
 * @param callback
 */
function performRequest(apartment, message, token, callback) {

    $.ajax(PROJECT_MODULE.messagesEndpoint.replace('{apartment}', apartment), {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        success: function () {
            callback({'success': true});
        },
        data: {
            'apartment_id': apartment,
            'body': message,
        },
        error: function (error) {
            console.log(error);
            callback({'success': false});
        }
    });
}

export default HANDLE_MESSAGE;