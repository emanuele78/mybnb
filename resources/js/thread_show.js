import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'
import MESSAGE_MODULE from "./send_message_mod";
import MODAL_MESSAGE_MODULE from "./modal_message_mod";

/**
 * entry point
 */
sendRequest();

/**
 * Send a request to retrieve all messages for the current thread
 */
function sendRequest() {
    let url = PROJECT_MODULE.threadEndpoint.replace('{thread}', $('#current_apartment').data('thread'));
    $.ajax(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            printResults(data);
        },
        error: function (e) {
            console.log(e);
        },
        complete: function () {
            //scroll to bottom on thread body when it is loaded
            $('.custom_container_body').scrollTop($('.custom_container_body').height());
        }
    });
}

/**
 * Print thread messages
 * @param data
 */
function printResults(data) {
    let template = Handlebars.compile($('#message-template').html());
    Handlebars.registerHelper('ifCond', function (message, options) {
        if ('unread' in message) {
            return options.fn(this);
        }
        return options.inverse(this);
    });
    Handlebars.registerHelper('senderName', function (sender) {
        return sender === data.thread_for_user ? 'Tu' : sender;
    });
    $('.custom_container_body').html(template(data.messages));
}

/**
 * Listener for sending message button
 */
$('#submit_message').click(function (e) {
    e.preventDefault();
    let textArea = $('#body');
    if (textArea.val().trim().length === 0) {
        textArea.addClass('is-invalid');
        return;
    }
    textArea.removeClass('is-invalid');
    $(this).attr('disabled', 'disabled');
    MESSAGE_MODULE.sendMessageToThread($('#current_apartment').data('thread'), textArea.val().trim(), $('meta[name="csrf-token"]').attr('content'), function (response) {
        if (response.success) {
            textArea.val('');
            sendRequest();
        } else {
            textArea.addClass('is-invalid');
        }
        $('#submit_message').removeAttr('disabled');
    });
});

/**
 * Listener for delete button
 */
$('#delete_button').click(function () {
    MODAL_MESSAGE_MODULE.showModule(null, null, function () {
        //user confirms deletion
        deleteThread();
    }, null);
});

/**
 * Send request to delete current thread
 */
function deleteThread() {
    let url = PROJECT_MODULE.threadEndpoint.replace('{thread}', $('#current_apartment').data('thread'));
    $.ajax(url, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            //go to dashboard
            window.location.href = $('#back_button').attr('href');
        },
        error: function (e) {
            console.log(e);
        }
    });
}
