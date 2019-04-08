require('./app');

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

function requestToken(email, elementToDisable, loadingElement) {
    $.ajax(TOKEN_ENDPOINT, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            loadingElement.collapse('show');
            elementToDisable.attr('disabled', 'disabled');
        },
        success: function (data) {
            $('#card-loading').html(data.message);
        },
        data: {
            email: email
        },
        error: function (error) {
            elementToDisable.removeAttr('disabled');
            $('#card-loading').html(error.responseJSON.message);
        }
    });
}

function isValidEmail(email) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}