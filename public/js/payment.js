(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/payment"],{

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");
/**
 * Declaring differents endpoint for development and production
 */


var LOCAL_PORT = 8000;
var PROJECT_CONSTANTS = {
  citiesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/cities',
  tokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/tokens',
  activationTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/tokens',
  apartmentAvailabilityEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/booking',
  messagesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/messages',
  mapEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/map',
  addressEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/address',
  paymentTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/payments/token',
  bookingPaymentEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/booking/payment'
};

if (false) {}

/* harmony default export */ __webpack_exports__["default"] = (PROJECT_CONSTANTS);

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.Popper = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js")["default"];
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

  __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {// console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/***/ }),

/***/ "./resources/js/payment.js":
/*!*********************************!*\
  !*** ./resources/js/payment.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app */ "./resources/js/app.js");


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