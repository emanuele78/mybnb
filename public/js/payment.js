(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/payment"],{

/***/ "./resources/js/payment.js":
/*!*********************************!*\
  !*** ./resources/js/payment.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app */ "./resources/js/app.js");

/**
 * Send a request to get the token for the payment
 */

(function () {
  var url = _app__WEBPACK_IMPORTED_MODULE_0__["default"].paymentTokenEndpoint;
  $.ajax(url, {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      loadDropIn(data.token);
    }
  });
})();
/**
 * NOTE: CODE FROM BRAINTREE WEBSITE
 *
 * load the form for the payment
 *
 * @param authorization
 */


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
          } // Remove any previously applied error or warning classes


          $(field.container).parents('.form-group').removeClass('has-warning');
          $(field.container).parents('.form-group').removeClass('has-success'); // Apply styling for a valid field

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
          $(field.container).parents('.form-group').addClass('has-warning'); // Add helper text for an invalid card number

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

          $.ajax(_app__WEBPACK_IMPORTED_MODULE_0__["default"].bookingPaymentEndpoint, {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function beforeSend() {
              $('.payment_result').hide();
              $('.card_payment_overlay').show();
            },
            success: function success() {
              $('.payment_section').remove();
              $('.payment_result_message').text('Grazie per l\'acquisto');
              $('.payment_result').show();
              $('.element_result').removeClass('error success').addClass('success');
            },
            error: function error(data) {
              var error_message;

              switch (data.message) {
                case 'invalid_data':
                  error_message = 'Errore durante l\'elaborazione';
                  $('.payment_section').remove();
                  break;

                case 'braintree_error':
                  error_message = 'Carta non valida';
                  $('.card_payment_overlay').hide();
                  break;

                case 'expired':
                  error_message = 'Sessione scaduta';
                  $('.payment_section').remove();
                  break;
              }

              $('.element_result').removeClass('error success').addClass('error');
              $('.payment_result_message').text(error_message);
              $('.payment_result').show();
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

/***/ }),

/***/ 12:
/*!***************************************!*\
  !*** multi ./resources/js/payment.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/payment.js */"./resources/js/payment.js");


/***/ })

},[[12,"/js/manifest","/js/vendor"]]]);