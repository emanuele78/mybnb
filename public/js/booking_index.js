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
/* harmony import */ var _fullcalendar_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @fullcalendar/core */ "./node_modules/@fullcalendar/core/main.js");
/* harmony import */ var _fullcalendar_core__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_fullcalendar_core__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _fullcalendar_daygrid__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fullcalendar/daygrid */ "./node_modules/@fullcalendar/daygrid/main.js");
/* harmony import */ var _fullcalendar_daygrid__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_fullcalendar_daygrid__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _node_modules_fullcalendar_core_main_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../node_modules/@fullcalendar/core/main.css */ "./node_modules/@fullcalendar/core/main.css");
/* harmony import */ var _node_modules_fullcalendar_core_main_css__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_node_modules_fullcalendar_core_main_css__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _node_modules_fullcalendar_daygrid_main_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../node_modules/@fullcalendar/daygrid/main.css */ "./node_modules/@fullcalendar/daygrid/main.css");
/* harmony import */ var _node_modules_fullcalendar_daygrid_main_css__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_node_modules_fullcalendar_daygrid_main_css__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _fullcalendar_core_locales_it__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @fullcalendar/core/locales/it */ "./node_modules/@fullcalendar/core/locales/it.js");
/* harmony import */ var _fullcalendar_core_locales_it__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_fullcalendar_core_locales_it__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _modal_info_mod__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./modal_info_mod */ "./resources/js/modal_info_mod.js");









var moment = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
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
        $('.main_title').text('Prenotazioni ricevute presso i tuoi appartamenti');
      } else if ($('.dropdown_show.active').data('show') === 'other_apartments_bookings') {
        $('.main_title').text('Prenotazioni fatte ad altri appartamenti');
      } else {
        $('.main_title').text('Prenotazioni fatte ad altri appartamenti (in sospeso)');
      }
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
 * Listener for button
 */


function registerButtonsListeners() {
  var expandBookingElement = $('.expand_booking_list');
  var expandCalendarElement = $('.expand_calendar'); //accordions for bookings received

  expandBookingElement.off();
  expandBookingElement.click(function () {
    $(this).text($(this).text() === 'Mostra elenco prenotazioni' ? 'Nascondi elenco prenotazioni' : 'Mostra elenco prenotazioni');
  });
  expandCalendarElement.off();
  expandCalendarElement.click(function () {
    $(this).text($(this).text() === 'Mostra calendario prenotazioni' ? 'Nascondi calendario prenotazioni' : 'Mostra calendario prenotazioni');
  }); //accordions for bookings made

  var expandOtherBookingsElements = $('.expand_booking_made');
  expandOtherBookingsElements.off();
  expandOtherBookingsElements.click(function () {
    $(this).text($(this).text() === 'Mostra prenotazioni fatte' ? 'Nascondi prenotazioni fatte' : 'Mostra prenotazioni fatte');
  });
  $('.resume_booking').click(function (e) {
    e.preventDefault();
    var location = $(this).attr('href');
    window.location.href = location.replace('booking', $(this).data('booking'));
  });
}
/**
 * Print the data received by the server
 * @param data
 */


function printResults(data) {
  if ($('.dropdown_show.active').data('show') === 'my_apartments_bookings') {
    generateHtml(data, $("#own-apartments-template"));
    initializeCalendarGrid(data);
  } else {
    generateHtml(data, $("#other-apartments-template"));
  }

  registerButtonsListeners();
}
/**
 * Initialize a calendar grid for each apartment
 * @param apartmentsWithBookings
 */


function initializeCalendarGrid(apartmentsWithBookings) {
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = apartmentsWithBookings[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var apartmentWithBookings = _step.value;
      var bookings = [];
      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = apartmentWithBookings.bookings[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var booking = _step2.value;
          bookings.push({
            id: booking.booking_reference,
            title: booking.user_fullname,
            start: moment(booking.check_in, "DD-MM-YYYY").format('YYYY-MM-DD'),
            end: moment(booking.check_out, "DD-MM-YYYY").add(1, 'days').format('YYYY-MM-DD')
          });
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
            _iterator2["return"]();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }

      new _fullcalendar_core__WEBPACK_IMPORTED_MODULE_2__["Calendar"]($('#calendar-' + apartmentWithBookings.apartment_slug)[0], {
        plugins: [_fullcalendar_daygrid__WEBPACK_IMPORTED_MODULE_3___default.a],
        defaultView: 'dayGridMonth',
        height: 500,
        locale: _fullcalendar_core_locales_it__WEBPACK_IMPORTED_MODULE_6___default.a,
        events: bookings,
        eventClick: function eventClick(info) {
          showBookingInfo(apartmentsWithBookings, info.event.id);
        }
      }).render();
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator["return"] != null) {
        _iterator["return"]();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }
}
/**
 * Show info of the given booking in a modal view
 * @param apartmentsWithBookings
 * @param reference
 */


function showBookingInfo(apartmentsWithBookings, reference) {
  console.log(apartmentsWithBookings);
  var _iteratorNormalCompletion3 = true;
  var _didIteratorError3 = false;
  var _iteratorError3 = undefined;

  try {
    for (var _iterator3 = apartmentsWithBookings[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
      var apartmentWithBookings = _step3.value;
      var _iteratorNormalCompletion4 = true;
      var _didIteratorError4 = false;
      var _iteratorError4 = undefined;

      try {
        for (var _iterator4 = apartmentWithBookings.bookings[Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
          var booking = _step4.value;

          if (booking.booking_reference === reference) {
            showModal(booking);
            return;
          }
        }
      } catch (err) {
        _didIteratorError4 = true;
        _iteratorError4 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion4 && _iterator4["return"] != null) {
            _iterator4["return"]();
          }
        } finally {
          if (_didIteratorError4) {
            throw _iteratorError4;
          }
        }
      }
    }
  } catch (err) {
    _didIteratorError3 = true;
    _iteratorError3 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion3 && _iterator3["return"] != null) {
        _iterator3["return"]();
      }
    } finally {
      if (_didIteratorError3) {
        throw _iteratorError3;
      }
    }
  }
}
/**
 * Show the given booking on a modal view
 * @param booking
 */


function showModal(booking) {
  console.log(booking);
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile($("#info-booking-template").html());
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.registerHelper('processAmount', function (options) {
    var amount = parseFloat(options.fn(this));
    return amount.toLocaleString('it-IT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  });
  $('#info_booking_content').html(template(booking));
  _modal_info_mod__WEBPACK_IMPORTED_MODULE_7__["default"].showInfoModal(function () {
    //user confirms deletion
    console.log("ok");
  });
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