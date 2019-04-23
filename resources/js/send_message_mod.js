import PROJECT_MODULE from "./app";

/**
 * Exported object
 *
 * @type {{send: HANDLE_MESSAGE.send}}
 */
const HANDLE_MESSAGE = {

    send: function (apartment, sender, recipient, message, token, callback) {
        performRequest(apartment, sender, recipient, message, token, callback);
    }
};

/**
 * Perform the request to send a message
 * @param apartment
 * @param sender
 * @param recipient
 * @param message
 * @param token
 * @param callback
 */
function performRequest(apartment, sender, recipient, message, token, callback) {
    $.ajax(PROJECT_MODULE.messagesEndpoint, {
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
            'sender_user_id': sender,
            'recipient_user_id': recipient,
            'body': message,
        },
        error: function (error) {
            console.log(error);
            callback({'success': false});
        }
    });
}

export default HANDLE_MESSAGE;