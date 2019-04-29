(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/booking_index"],{

/***/ "./resources/js/booking_index.js":
/*!***************************************!*\
  !*** ./resources/js/booking_index.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__);


/**
 * Entry point
 */

sendRequest();
registerListenerForDropdowns();
/**
 * Send request to get data for own bookings | other apartments bookings
 */

function sendRequest() {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].bookingListEndpoint;
  $.ajax(url, {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'show_by': $('.dropdown_show.active').data('show'),
      'filter': $('.dropdown_filter.active').data('filter')
    },
    success: function success(data) {
      if (data.length) {
        printResults(data);
      } else {
        printNoResults();
      }
    },
    error: function error(e) {
      console.log(e);
    },
    complete: function complete() {
      if ($('.dropdown_show.active').data('show') === 'my_apartments_bookings') {
        $('.main_message_title').text('Prenotazioni effettuate ai tuoi appartamenti');
      } else if ($('.dropdown_show.active').data('show') === 'other_apartments_bookings') {
        $('.main_message_title').text('Prenotazioni effettuate ad altri appartamenti');
      } else {
        $('.main_message_title').text('Prenotazioni effettuate ad altri appartamenti (in sospeso)');
      } // attachDeleteButtonsListeners();

    }
  });
}
/**
 * Listener for dropdowns
 */


function registerListenerForDropdowns() {
  $('.dropdown_filter').click(function (e) {
    e.preventDefault();
    $('.dropdown_filter').removeClass('active');
    $(this).addClass('active');
    sendRequest();
  });
  $('.dropdown_show').click(function (e) {
    e.preventDefault();
    $('.dropdown_show').removeClass('active');
    $(this).addClass('active');
    sendRequest();
  });
}
/**
 * Listener for accordion toggling
 */


function registerListenerForAccordion() {
  $('.expand_bookings').off();
  $('.expand_bookings').click(function () {
    $(this).text($(this).text() === 'Mostra conversazioni' ? 'Nascondi conversazioni' : 'Mostra conversazioni');
  });
}
/**
 * Print the data received by the server
 * @param data
 */


function printResults(data) {
  if ($('.dropdown_show.active').data('show') === 'my_apartments_bookings') {
    generateHtml(data, $("#own-apartments-template"));
    registerListenerForAccordion();
  } else {
    generateHtml(data, $("#other-apartments-template"));
    registerListenerForAccordion();
  }
}
/**
 * Template for no data
 */


function printNoResults() {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile($("#no-results-template").html());
  $('.content_wrapper').html(template());
}
/**
 * Template for data
 * @param data
 * @param templateElement
 */


function generateHtml(data, templateElement) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile(templateElement.html());
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.registerHelper('processAmount', function (options) {
    var amount = parseFloat(options.fn(this));
    return amount.toLocaleString('it-IT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  });
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.registerHelper('ifCond', function (value, options) {
    if (value === 'confirmed') {
      return options.fn(this);
    }

    return options.inverse(this);
  });
  $('.content_wrapper').html(template(data));
}

/***/ }),

/***/ 16:
/*!*********************************************!*\
  !*** multi ./resources/js/booking_index.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/booking_index.js */"./resources/js/booking_index.js");


/***/ })

},[[16,"/js/manifest","/js/vendor"]]]);