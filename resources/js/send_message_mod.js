import PROJECT_MODULE from "./app";

/**
 * Exported object
 *
 */
const HANDLE_MESSAGE = {

    sendMessageToApartment: function (apartment, message, token, callback) {
        performRequestForApartment(apartment, message, token, callback);
    },
    sendMessageToThread: function (thread, message, token, callback) {
        performRequestForThread(thread, message, token, callback);
    }

};

/**
 * Perform the request to send a message
 * @param apartment
 * @param message
 * @param token
 * @param callback
 */
function performRequestForApartment(apartment, message, token, callback) {

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

/**
 * Sending messge inside a thread
 * @param thread
 * @param message
 * @param token
 * @param callback
 */
function performRequestForThread(thread, message, token, callback) {
    $.ajax(PROJECT_MODULE.threadEndpoint.replace('{thread}', thread), {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        success: function () {
            callback({'success': true});
        },
        data: {
            'body': message,
        },
        error: function (error) {
            console.log(error);
            callback({'success': false});
        }
    });
}

export default HANDLE_MESSAGE;