import PROJECT_MODULE from "./app";

(function () {
    let url = PROJECT_MODULE.paymentTokenEndpoint;
    $.ajax(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            loadDropIn(data.token)
        }
    });
})();

function loadDropIn(authorization) {
    braintree.client.create({
        authorization: authorization
    }, function (err, clientInstance) {
        if (err) {
            console.error(err);
            return;
        }

        braintree.hostedFields.create({
            client: clientInstance,
            styles: {
                'input': {
                    'font-size': '14px',
                    'font-family': 'helvetica, tahoma, calibri, sans-serif',
                    'color': '#3a3a3a'
                },
                ':focus': {
                    'color': 'black'
                }
            },
            fields: {
                number: {
                    selector: '#card-number',
                    placeholder: '4111 1111 1111 1111'
                },
                cvv: {
                    selector: '#cvv',
                    placeholder: '123'
                },
                expirationMonth: {
                    selector: '#expiration-month',
                    placeholder: 'MM'
                },
                expirationYear: {
                    selector: '#expiration-year',
                    placeholder: 'YY'
                },
                postalCode: {
                    selector: '#postal-code',
                    placeholder: '90210'
                }
            }
        }, function (err, hostedFieldsInstance) {
            if (err) {
                console.error(err);
                return;
            }
            $('.card_payment_overlay').hide();
            hostedFieldsInstance.on('validityChange', function (event) {
                var field = event.fields[event.emittedBy];

                if (field.isValid) {
                    if (event.emittedBy === 'expirationMonth' || event.emittedBy === 'expirationYear') {
                        if (!event.fields.expirationMonth.isValid || !event.fields.expirationYear.isValid) {
                            return;
                        }
                    } else if (event.emittedBy === 'number') {
                        $('#card-number').next('span').text('');
                    }

                    // Remove any previously applied error or warning classes
                    $(field.container).parents('.form-group').removeClass('has-warning');
                    $(field.container).parents('.form-group').removeClass('has-success');
                    // Apply styling for a valid field
                    $(field.container).parents('.form-group').addClass('has-success');
                } else if (field.isPotentiallyValid) {
                    // Remove styling  from potentially valid fields
                    $(field.container).parents('.form-group').removeClass('has-warning');
                    $(field.container).parents('.form-group').removeClass('has-success');
                    if (event.emittedBy === 'number') {
                        $('#card-number').next('span').text('');
                    }
                } else {
                    // Add styling to invalid fields
                    $(field.container).parents('.form-group').addClass('has-warning');
                    // Add helper text for an invalid card number
                    if (event.emittedBy === 'number') {
                        $('#card-number').next('span').text('Looks like this card number has an error.');
                    }
                }
            });

            hostedFieldsInstance.on('cardTypeChange', function (event) {
                // Handle a field's change, such as a change in validity or credit card type
                if (event.cards.length === 1) {
                    $('#card-type').text(event.cards[0].niceType);
                } else {
                    $('#card-type').text('Card');
                }
            });

            $('.panel-body').submit(function (event) {
                event.preventDefault();
                hostedFieldsInstance.tokenize(function (err, payload) {
                    if (err) {
                        console.error(err);
                        $('.payment_result_message').text('Controlla i campi inseriti');
                        $('.payment_result').show();
                        $('.element_result').removeClass('error success').addClass('error');
                        return;
                    }
                    $.ajax(PROJECT_MODULE.bookingPaymentEndpoint, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('.payment_result').hide();
                            $('.card_payment_overlay').show();
                        },
                        success: function () {
                            $('.payment_section').remove();
                            $('.payment_result_message').text('Grazie per l\'acquisto');
                            $('.payment_result').show();
                            $('.element_result').removeClass('error success').addClass('success');
                        },
                        error: function (data) {
                            switch (data.message) {
                                case 'invalid_data':
                                    $('.payment_section').remove();
                                    $('.payment_result_message').text('Errore durante l\'elaborazione');
                                    $('.payment_result').show();
                                    $('.element_result').removeClass('error success').addClass('error');
                                    break;
                                case 'braintree_error':
                                    $('.card_payment_overlay').hide();
                                    $('.payment_result_message').text('Carta non valida');
                                    $('.payment_result').show();
                                    $('.element_result').removeClass('error success').addClass('error');
                                    break;
                                case 'expired':
                                    $('.payment_section').remove();
                                    $('.payment_result_message').text('Sessione scaduta');
                                    $('.payment_result').show();
                                    $('.element_result').removeClass('error success').addClass('error');
                                    break;
                            }
                        },
                        data: {
                            'paymentMethodNonce': payload.nonce,
                            'booking_reference': $('#booking_ref').data('reference')
                        }
                    });
                });
            });
        });
    });
}