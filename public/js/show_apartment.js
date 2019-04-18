(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/show_apartment"],{

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

/***/ "./resources/js/load_address_mod.js":
/*!******************************************!*\
  !*** ./resources/js/load_address_mod.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app */ "./resources/js/app.js");

var HANDLE_ADDRESS = {
  getAddress: function getAddress(apartment, callback) {
    performRequest(apartment, callback);
  }
};

function performRequest(apartment, callback) {
  var URL = _app__WEBPACK_IMPORTED_MODULE_0__["default"].addressEndpoint.replace('{apartment}', apartment);
  $.ajax(URL, {
    method: 'GET',
    success: function success(data) {
      callback({
        'success': true,
        'data': data
      });
    },
    error: function error() {
      callback({
        'success': false
      });
    }
  });
}

/* harmony default export */ __webpack_exports__["default"] = (HANDLE_ADDRESS);

/***/ }),

/***/ "./resources/js/load_map_mod.js":
/*!**************************************!*\
  !*** ./resources/js/load_map_mod.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app */ "./resources/js/app.js");

var HANDLE_MAP = {
  getMap: function getMap(apartment, callback) {
    performRequest(apartment, callback);
  }
};

function performRequest(apartment, callback) {
  var URL = _app__WEBPACK_IMPORTED_MODULE_0__["default"].mapEndpoint.replace('{apartment}', apartment);
  $.ajax(URL, {
    method: 'GET',
    success: function success(data) {
      callback({
        'success': true,
        'data': data
      });
    },
    error: function error() {
      callback({
        'success': false
      });
    }
  });
}

/* harmony default export */ __webpack_exports__["default"] = (HANDLE_MAP);

/***/ }),

/***/ "./resources/js/send_message_mod.js":
/*!******************************************!*\
  !*** ./resources/js/send_message_mod.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app */ "./resources/js/app.js");

var HANDLE_MESSAGE = {
  send: function send(apartment, sender, recipient, message, token, callback) {
    performRequest(apartment, sender, recipient, message, token, callback);
  }
};

function performRequest(apartment, sender, recipient, message, token, callback) {
  $.ajax(_app__WEBPACK_IMPORTED_MODULE_0__["default"].messagesEndpoint, {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': token
    },
    success: function success() {
      callback({
        'success': true
      });
    },
    data: {
      'apartment_slug': apartment,
      'sender_nickname': sender,
      'recipient_nickname': recipient,
      'body': message
    },
    error: function error(_error) {
      console.log(_error);
      callback({
        'success': false
      });
    }
  });
}

/* harmony default export */ __webpack_exports__["default"] = (HANDLE_MESSAGE);

/***/ }),

/***/ "./resources/js/show_apartment.js":
/*!****************************************!*\
  !*** ./resources/js/show_apartment.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _load_map_mod__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./load_map_mod */ "./resources/js/load_map_mod.js");
/* harmony import */ var _load_address_mod__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./load_address_mod */ "./resources/js/load_address_mod.js");
/* harmony import */ var _send_message_mod__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./send_message_mod */ "./resources/js/send_message_mod.js");




(function () {
  var APARTMENT_SLUG = $('#tomtom_map').data().apartment;
  _load_map_mod__WEBPACK_IMPORTED_MODULE_0__["default"].getMap(APARTMENT_SLUG, function (response) {
    if (response.success) {
      $('.loading_map').hide();
      $('#marker').show();
      $('#tomtom_map').attr('src', "data:image/png;charset=binary;base64," + response.data);
    } else {
      $('.loading_map').html('N/D');
    }
  });
  _load_address_mod__WEBPACK_IMPORTED_MODULE_1__["default"].getAddress(APARTMENT_SLUG, function (response) {
    if (response.success) {
      $('#apartment_address').text(formatAddress(response.data));
    } else {
      $('#apartment_address').text('Indirizzo non disponibile');
    }
  });

  function formatAddress(data) {
    var formatted_address = [];

    if (!isEmpty(data.streetName)) {
      formatted_address.push(data.streetName);
    }

    if (!isEmpty(data.municipality)) {
      formatted_address.push(data.municipality);
    }

    if (!isEmpty(data.postal_code)) {
      formatted_address.push('(' + data.postal_code + ')');
    }

    if (!isEmpty(data.province)) {
      formatted_address.push(data.province);
    }

    return formatted_address.join(', ');
  }

  function isEmpty(value) {
    return !value || value.length === 0;
  }
})();

$('#submit_message').click(function (e) {
  e.preventDefault();
  var textArea = $('#body');

  if (textArea.val().length < 10) {
    textArea.addClass('is-invalid');
    return;
  }

  textArea.removeClass('is-invalid');
  var apartment = $("#message_apartment_slug").val();
  var sender = $("#message_sender_nickname").val();
  var recipient = $("#message_recipient_nickname").val();
  $(this).attr('disabled', 'disabled');
  _send_message_mod__WEBPACK_IMPORTED_MODULE_2__["default"].send(apartment, sender, recipient, textArea.val(), $('meta[name="csrf-token"]').attr('content'), function (response) {
    if (response.success) {
      $('#message_wrapper').removeClass('alert-danger');
      $('#message_wrapper').addClass('alert-success');
      $('#message_response').text('Messaggio inviato correttamente');
      textArea.val('');
    } else {
      $('#message_wrapper').removeClass('alert-success');
      $('#message_wrapper').addClass('alert-danger');
      $('#message_response').text('Errore durante l\'invio del messaggio');
    }

    $('#submit_message').removeAttr('disabled');
  });
});

/***/ }),

/***/ 9:
/*!**********************************************!*\
  !*** multi ./resources/js/show_apartment.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/show_apartment.js */"./resources/js/show_apartment.js");


/***/ })

},[[9,"/js/manifest","/js/vendor"]]]);