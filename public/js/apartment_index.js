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
/* harmony import */ var _modal_action_mod__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modal_action_mod */ "./resources/js/modal_action_mod.js");



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
      'show': $('.dropdown_show.active').data('show'),
      'order': $('.dropdown_order.active').data('order')
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
  $('.dropdown_order').click(function (e) {
    e.preventDefault();
    $('.dropdown_order').removeClass('active');
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
    changeApartmentVisibility(currentApartment, true, function () {
      //reload
      sendRequest();
    });
  });
  $('.hide_apartment').off().click(function () {
    var currentApartment = $(this).data('apartment');
    $('.waiting.' + currentApartment).show();
    changeApartmentVisibility(currentApartment, false, function () {
      //reload
      sendRequest();
    });
  });
  $('.delete_apartment').off().click(function () {
    var currentApartment = $(this).data('apartment');
    _modal_action_mod__WEBPACK_IMPORTED_MODULE_2__["default"].showActionModal(null, null, function () {
      //user confirms deletion
      deleteApartment(currentApartment, function () {
        //reload
        sendRequest();
      });
    }, null);
  });
  $('.edit_apartment').off().click(function () {
    var url = $(this).data('ref').replace('apartment', $(this).data('apartment'));
    window.location.href = url;
  });
}
/**
 * Change the visibility of the given apartment
 * @param apartment
 * @param set_visible
 * @param callback
 */


function changeApartmentVisibility(apartment, set_visible, callback) {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].apartmentVisibilityEndpoint.replace('{apartment}', apartment);
  $.ajax(url, {
    method: 'PATCH',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'is_showed': set_visible ? 1 : 0
    },
    error: function error(e) {
      console.log(e);
    },
    complete: function complete() {
      callback();
    }
  });
}
/**
 * Send request to delete given apartment
 * @param apartment
 * @param callback
 */


function deleteApartment(apartment, callback) {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].apartmentsEndpoint + '/' + apartment;
  $.ajax(url, {
    method: 'DELETE',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success() {
      callback();
    },
    error: function error(e) {
      console.log(e);
    }
  });
}

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