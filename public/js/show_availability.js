(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/show_availability"],{

/***/ "./resources/js/show_availability.js":
/*!*******************************************!*\
  !*** ./resources/js/show_availability.js ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flatpickr */ "./node_modules/flatpickr/dist/flatpickr.js");
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flatpickr__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _check_availability_mod__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./check_availability_mod */ "./resources/js/check_availability_mod.js");
/* harmony import */ var flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flatpickr/dist/l10n/it.js */ "./node_modules/flatpickr/dist/l10n/it.js");
/* harmony import */ var flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_2__);



/**
 * Initialize flatpicker
 */

flatpickr__WEBPACK_IMPORTED_MODULE_0___default()('.flatpicker', {
  clickOpens: true,
  dateFormat: "d-m-Y",
  "locale": flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_2__["Italian"]
});
/**
 * Listener for check availability button
 */

$('#check_availability').click(function () {
  var checkIn = $('#check_in');
  var checkOut = $('#check_out');
  $('#check_availability').attr('disabled', 'disabled');
  $('.loading_block').show();
  _check_availability_mod__WEBPACK_IMPORTED_MODULE_1__["default"].check(checkIn.val(), checkOut.val(), $('#check_availability').data().apartment, function (result) {
    checkIn.removeClass('is-invalid');
    checkOut.removeClass('is-invalid');
    $('#check_availability').removeAttr('disabled');
    var message;
    var classColor;

    switch (result) {
      case 'INVALID_CHECK_IN':
        checkIn.addClass('is-invalid');
        break;

      case 'INVALID_CHECK_OUT':
        checkOut.addClass('is-invalid');
        break;

      case 'SERVER_ERROR':
        message = "dato non disponibile";
        classColor = "text-primary";
        break;

      case 'AVAILABLE':
        classColor = "text-success";
        message = "disponibile";
        break;

      case 'NOT_AVAILABLE':
        classColor = "text-danger";
        message = "non disponibile";
        break;
    }

    $('#result').removeClass().addClass(classColor).text(message);
    $('.loading_block').hide();
  }, false);
});

/***/ }),

/***/ 5:
/*!*************************************************!*\
  !*** multi ./resources/js/show_availability.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/show_availability.js */"./resources/js/show_availability.js");


/***/ })

},[[5,"/js/manifest","/js/vendor"]]]);