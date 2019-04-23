import PROJECT_MODULE from './app.js';

/**
 * Listener for request token button
 */
$('#request_token_button').click(function (e) {
    e.preventDefault();
    let emailElement = $('#email');
    let emailValue = emailElement.val();
    if (isValidEmail(emailValue)) {
        //do ajax request
        emailElement.removeClass('is-invalid');
        requestToken(emailValue, $(this), $('#loading-element'));
    } else {
        emailElement.addClass('is-invalid');
    }
});

/**
 * Perform ajax call to request a new token for the provided email address
 * @param email
 * @param elementToDisable
 * @param loadingElement
 */
function requestToken(email, elementToDisable, loadingElement) {
    $.ajax(PROJECT_MODULE.tokenEndpoint, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            loadingElement.collapse('show');
            elementToDisable.attr('disabled', 'disabled');
        },
        success: function () {
            $('#card-loading').html('Il token è stato inviato');
        },
        data: {
            email: email
        },
        error: function () {
            elementToDisable.removeAttr('disabled');
            $('#card-loading').html('Indirizzo e-mail non valido');
        }
    });
}

/**
 * Checks if the passed string is a valid email address
 * @param email
 * @returns {boolean}
 */
function isValidEmail(email) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Listener for the activate token button
 */
$('#activate_token_button').click(function (e) {
    e.preventDefault();
    let tokenInput = $('#token_code');
    if ($.trim(tokenInput.val()) === '') {
        tokenInput.addClass('is-invalid');
    } else {
        $('#activation_form').attr('action', PROJECT_MODULE.activationTokenEndpoint + '/' + tokenInput.val());
        $('#activation_form').submit();
    }
});