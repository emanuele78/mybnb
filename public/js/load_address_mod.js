(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/load_address_mod"],{

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

/***/ 11:
/*!************************************************!*\
  !*** multi ./resources/js/load_address_mod.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/load_address_mod.js */"./resources/js/load_address_mod.js");


/***/ })

},[[11,"/js/manifest","/js/vendor"]]]);