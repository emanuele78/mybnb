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
/* harmony import */ var _payment_mod__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./payment_mod */ "./resources/js/payment_mod.js");


/**
 * Handle the payment
 */

(function () {
  var PAYLOAD = {
    'booking_reference': $('#booking_ref').data('reference')
  };
  var CSRF = $('meta[name="csrf-token"]').attr('content');
  _payment_mod__WEBPACK_IMPORTED_MODULE_1__["default"].initialize(CSRF, _app__WEBPACK_IMPORTED_MODULE_0__["default"].bookingPaymentEndpoint, PAYLOAD);
})();

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