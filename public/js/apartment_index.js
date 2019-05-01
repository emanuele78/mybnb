(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/apartment_index"],{

/***/ "./resources/js/apartment_index.js":
/*!*****************************************!*\
  !*** ./resources/js/apartment_index.js ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _modal_info_mod__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modal_info_mod */ "./resources/js/modal_info_mod.js");



/**
 * Entry point
 */

sendRequest();
registerListenerForDropdowns();
/**
 * Send request to get data for own bookings | other apartments bookings
 */

function sendRequest() {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].apartmentsEndpoint;
  $.ajax(url, {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'show': $('.dropdown_show.active').data('show')
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
 * Print the data received by the server
 * @param data
 */


function printResults(data) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile($("#apartment-template").html());
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.registerHelper('processAmount', function (options) {
    var amount = parseFloat(options.fn(this));
    return amount.toLocaleString('it-IT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  });
  $('.content_wrapper').html(template(data));
  registerListenerForInPageActions();
}
/**
 * Template for no data
 */


function printNoResults() {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile($("#no-results-template").html());
  $('.content_wrapper').html(template());
}
/**
 * Register listener for delete and show/hide apartment buttons
 */


function registerListenerForInPageActions() {
  $('.show_apartment').off().click(function () {
    var currentApartment = $(this).data('apartment');
    $('.waiting.' + currentApartment).show();
    performAction(currentApartment, 'set_visible', function (success) {});
  });
  $('.hide_apartment').off().click(function () {
    var currentApartment = $(this).data('apartment');
    $('.waiting.' + currentApartment).show();
    performAction(currentApartment, 'set_hidden', function (success) {});
  });
}

function performAction(apartment, action, callback) {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].apartmentEndpoint.replace('{apartment}', apartment);
  var success = true;
  $.ajax(url, {
    method: 'PATCH',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'action': action
    },
    success: function success(data) {
      console.log(data);
    },
    error: function error(e) {
      success = false;
      console.log(e);
    },
    complete: function complete() {
      sendRequest();
    }
  });
}

function removeCard(apartment) {
  $('.apartment-card-' + apartment).remove();
} // /**
//  * Listener for accordion toggling
//  */
// function registerListenersForAccordion() {
//     $('.expand_booking_list').off();
//     $('.expand_booking_list').click(function () {
//         $(this).text($(this).text() === 'Mostra elenco prenotazioni' ? 'Nascondi elenco prenotazioni' : 'Mostra elenco prenotazioni');
//     });
//     $('.expand_calendar').off();
//     $('.expand_calendar').click(function () {
//         $(this).text($(this).text() === 'Mostra calendario prenotazioni' ? 'Nascondi calendario prenotazioni' : 'Mostra calendario prenotazioni');
//     });
// }
// /**
//  * Show info of the given booking in a modal view
//  * @param apartmentsWithBookings
//  * @param reference
//  */
// function showBookingInfo(apartmentsWithBookings, reference) {
//     console.log(apartmentsWithBookings);
//     for (let apartmentWithBookings of apartmentsWithBookings) {
//         for (let booking of apartmentWithBookings.bookings) {
//             if (booking.booking_reference === reference) {
//                 showModal(booking);
//                 return;
//             }
//         }
//     }
// }
//
// /**
//  * Show the given booking on a modal view
//  * @param booking
//  */
// function showModal(booking) {
//     console.log(booking);
//     let template = Handlebars.compile($("#info-booking-template").html());
//     Handlebars.registerHelper('processAmount', function (options) {
//         let amount = parseFloat(options.fn(this));
//         return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
//     });
//     $('#info_booking_content').html(template(booking));
//     MODAL_INFO_MODULE.showInfoModal(function () {
//         //user confirms deletion
//         console.log("ok");
//     });
// }

/***/ }),

/***/ 18:
/*!***********************************************!*\
  !*** multi ./resources/js/apartment_index.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/apartment_index.js */"./resources/js/apartment_index.js");


/***/ })

},[[18,"/js/manifest","/js/vendor"]]]);