import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'
import MESSAGE_MODULE from "./send_message_mod";

sendRequest();

function sendRequest() {
    let url = PROJECT_MODULE.threadEndpoint.replace('{apartment}', $('#current_apartment').data('apartment')).replace('{thread}', $('#current_apartment').data('thread'));
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

function printResults(data) {
    let template = Handlebars.compile($('#message-template').html());
    Handlebars.registerHelper('ifCond', function (message, options) {
        if ('unreaded' in message) {
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
    if (textArea.val().length < 10) {
        textArea.addClass('is-invalid');
        return;
    }
    textArea.removeClass('is-invalid');
    let apartment = $("#message_apartment_slug").val();
    let sender = $("#message_sender_nickname").val();
    let recipient = $("#message_recipient_nickname").val();
    $(this).attr('disabled', 'disabled');
    MESSAGE_MODULE.send(apartment, sender, recipient, textArea.val(), $('meta[name="csrf-token"]').attr('content'), function (response) {
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
    //show confirmation message
    $('#delete_message').modal('show');
});

/**
 * Listener for modal delete button
 */
$('#confirm_delete_button').click(function () {
    $('#delete_message').modal('hide');
});
