(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/promotion"],{

/***/ "./resources/js/promotion.js":
/*!***********************************!*\
  !*** ./resources/js/promotion.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flatpickr */ "./node_modules/flatpickr/dist/flatpickr.js");
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flatpickr__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _payment_mod__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./payment_mod */ "./resources/js/payment_mod.js");





var MOMENT = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/**
 * Entry point
 */


(function () {
  //Flatpicker initialization
  flatpickr__WEBPACK_IMPORTED_MODULE_1___default()('.flatpicker', {
    clickOpens: true,
    enableTime: true,
    dateFormat: "d-m-Y H:i",
    onChange: function onChange() {
      $('.flatpickr-input').removeClass('is-invalid');
    }
  }); //listener for promo card choice

  $('.promo_type_card').click(function () {
    $('.promo_type_card').removeClass('active');
    $(this).addClass('active');
    loadDaysForSelectedPromo($(this).data('max_length'));
    calcPrice();
  }); //listener for day select

  $('.promo_length').change(function () {
    calcPrice();
  }); //Listener for proceed button

  $('.button_proceed').click(function () {
    if ($('input[type="radio"]:checked').val() === 'start_date') {
      var userDate = $('.flatpickr-input').val();

      if (userDate && validDate(userDate)) {
        checkIfOverlapped(userDate, $('.promo_type_card.active').data('card_type'), $('.promo_length option:selected').val());
      } else {
        $('.flatpickr-input').removeClass('is-invalid').addClass('is-invalid');
        $('.start_promo_input').text('data non valida');
      }
    } else {
      checkIfOverlapped(null, $('.promo_type_card.active').data('card_type'), $('.promo_length option:selected').val());
    }
  }); //listener for back button

  $('.back_button').click(function () {
    toggleView();
  }); //load day for active promo and calc price

  loadDaysForSelectedPromo($('.promo_type_card').data('max_length'));
  calcPrice();
})();
/**
 * Calc the total amout for the select value
 */


function calcPrice() {
  var days = $('.promo_length option:selected').val();
  var pricePerDay = $('.promo_type_card.active .promo_price').data('price');
  var amount = (days * pricePerDay).toLocaleString('it-IT', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
  $('.amount').text(amount);
}
/**
 * Check if user date is a future date
 * @param userDate
 * @returns {boolean}
 */


function validDate(userDate) {
  var momentDate = MOMENT(userDate, 'DD-MM-YYYY H:i');
  return momentDate.isSameOrAfter(MOMENT(), 'minute');
}
/**
 * Populate select with days count
 * @param day_count
 */


function loadDaysForSelectedPromo(day_count) {
  var data = [];

  for (var i = 1; i <= day_count; i++) {
    data.push(i);
  }

  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_2___default.a.compile($("#length-template").html());
  $('.promo_length').html(template(data));
}
/**
 * Send request to check if the choose promo overlaps another promo
 * @param startDate
 * @param cardType
 * @param dayLength
 */


function checkIfOverlapped(startDate, cardType, dayLength) {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].promotionEndpoint.replace('{apartment}', $('.apartment_title').data('apartment'));
  $.ajax(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'card_type': cardType,
      'start_at': startDate,
      'day_length': dayLength
    },
    success: function success(data) {
      evaluateResponse(data.overlaps, startDate, cardType, dayLength);
    },
    error: function error(e) {
      console.log(e);
    }
  });
}
/**
 * Show/hide promotion detail/payment form
 */


function toggleView() {
  $('.promo_detail').toggle();
  $('.payment_module').toggle();
}
/**
 * If promotion not overlaps, proceed with payment
 * @param overlaps
 * @param startDate
 * @param cardType
 * @param dayLength
 */


function evaluateResponse(overlaps, startDate, cardType, dayLength) {
  if (overlaps) {
    $('.flatpickr-input').removeClass('is-invalid').addClass('is-invalid');
    $('.start_promo_input').text('La data è sovrapposta con quella di un\'altra promozione');
    return;
  }

  toggleView();
  var PAYLOAD = {
    'card_type': cardType,
    'day_length': dayLength,
    'start_at': startDate
  };
  var CSRF = $('meta[name="csrf-token"]').attr('content');
  var ENDPOINT = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].promotionPaymentEndpoint.replace('{apartment}', $('.apartment_title').data('apartment'));
  _payment_mod__WEBPACK_IMPORTED_MODULE_3__["default"].initialize(CSRF, ENDPOINT, PAYLOAD);
}

/***/ }),

/***/ 22:
/*!*****************************************!*\
  !*** multi ./resources/js/promotion.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/promotion.js */"./resources/js/promotion.js");


/***/ })

},[[22,"/js/manifest","/js/vendor"]]]);