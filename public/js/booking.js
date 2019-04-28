(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/booking"],{

/***/ "./resources/js/booking.js":
/*!*********************************!*\
  !*** ./resources/js/booking.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flatpickr */ "./node_modules/flatpickr/dist/flatpickr.js");
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flatpickr__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _check_availability_mod__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./check_availability_mod */ "./resources/js/check_availability_mod.js");


/**
 * Flatpicker initialization
 */

flatpickr__WEBPACK_IMPORTED_MODULE_0___default()('.flatpicker', {
  clickOpens: true,
  dateFormat: "d-m-Y",
  onChange: function onChange() {
    check();
  }
});
/**
 * function that responds to event associate to upgrade checkboxes and flatpicker date.
 * Send ajax request to get availability for selected dates through module
 */

function check() {
  var checkIn = $('#check_in');
  var checkOut = $('#check_out');
  $('.loading_block').show();
  $('#result').text();
  _check_availability_mod__WEBPACK_IMPORTED_MODULE_1__["default"].check(checkIn.val(), checkOut.val(), $('#availability_result').data().apartment, function (result, days) {
    checkIn.removeClass('is-invalid');
    checkOut.removeClass('is-invalid');
    var message;
    var classColor;
    var valid = false;

    switch (result) {
      case 'INVALID_CHECK_IN':
        checkIn.addClass('is-invalid');
        break;

      case 'INVALID_CHECK_OUT':
        checkOut.addClass('is-invalid');
        break;

      case 'SERVER_ERROR':
        classColor = "error";
        message = "dato non disponibile";
        break;

      case 'AVAILABLE':
        classColor = "available";
        message = "disponibile";
        valid = true;
        break;

      case 'NOT_AVAILABLE':
        classColor = "not_available";
        message = "non disponibile";
        break;
    }

    $('#availability_result').removeClass().addClass(classColor);
    $('.loading_block').hide();
    $('#result').text(message);
    calc(days, valid);

    if (valid) {
      $('#proceed_to_booking').removeClass('btn-secondary btn-success').addClass('btn-success');
    } else {
      $('#proceed_to_booking').removeClass('btn-secondary btn-success').addClass('btn-secondary');
    }
  }, true, $('meta[name="csrf-token"]').attr('content'));
}
/**
 * Calc the amount for selected dates
 * @param days
 * @param valid
 */


function calc(days, valid) {
  var day_count = $('#day_count');
  var apartment_amount = $('#apartment_amount');
  var services_amount = $('#services_amount');
  var final_amount = $('#final_amount');
  day_count.text('');
  apartment_amount.text('');
  services_amount.text('');
  final_amount.text('');
  var base_price;

  if (valid) {
    day_count.text(days);

    if ($('.apartment_sale_price').length) {
      base_price = $('.apartment_sale_price').data('apartment_sale_price');
    } else {
      base_price = $('.apartment_price').data('apartment_price');
    }

    apartment_amount.text(representAmount(base_price * days));
    var checked_services_amount = 0;
    $('.upgrade_service').each(function () {
      if ($(this).is(':checked')) {
        checked_services_amount += $(this).data('service_price');
      }
    });
    services_amount.text(representAmount(checked_services_amount * days));
    final_amount.text(representAmount((checked_services_amount + base_price) * days));
  }
}
/**
 * Show the amount to the user
 * @param amount
 * @returns {string}
 */


function representAmount(amount) {
  return amount.toLocaleString('it-IT', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}
/**
 * Listener for upgrade service checboxes
 */


$('.upgrade_service').change(function () {
  check();
});

/***/ }),

/***/ 7:
/*!***************************************!*\
  !*** multi ./resources/js/booking.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/booking.js */"./resources/js/booking.js");


/***/ })

},[[7,"/js/manifest","/js/vendor"]]]);