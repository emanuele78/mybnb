import PROJECT_MODULE from "./app";

const HANDLE_MESSAGE = {

    send: function (apartment, sender, recipient, message, token, callback) {
        performRequest(apartment, sender, recipient, message, token, callback);
    }
};

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