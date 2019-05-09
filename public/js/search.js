(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/search"],{

/***/ "./resources/js/search.js":
/*!********************************!*\
  !*** ./resources/js/search.js ***!
  \********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app */ "./resources/js/app.js");
/* harmony import */ var bootstrap_slider_dist_bootstrap_slider__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! bootstrap-slider/dist/bootstrap-slider */ "./node_modules/bootstrap-slider/dist/bootstrap-slider.js");
/* harmony import */ var bootstrap_slider_dist_bootstrap_slider__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(bootstrap_slider_dist_bootstrap_slider__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flatpickr */ "./node_modules/flatpickr/dist/flatpickr.js");
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flatpickr__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flatpickr/dist/l10n/it.js */ "./node_modules/flatpickr/dist/l10n/it.js");
/* harmony import */ var flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _search_mod__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./search_mod */ "./resources/js/search_mod.js");







var MOMENT = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js"); //initialize slider for distance radius


var RADIUS_SLIDER = $('#radius_slider').slider(); //initialize slider for price

var PRICE_SLIDER = $('#price_slider').slider();
/**
 * Entry point
 */

(function () {
  RADIUS_SLIDER.on('change', function (e) {
    printKmRadius(e.value.newValue);
  });
  PRICE_SLIDER.on('change', function (e) {
    printRangePrice(e.value.newValue);
  }); //sliders listener

  RADIUS_SLIDER.slider().on('slideStop', function () {
    checkData();
  });
  PRICE_SLIDER.slider().on('slideStop', function () {
    checkData();
  }); //print default value

  printKmRadius(RADIUS_SLIDER.slider('getValue'));
  printRangePrice(PRICE_SLIDER.slider('getValue')); //initialize flatpicker

  flatpickr__WEBPACK_IMPORTED_MODULE_2___default()('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
    "locale": flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3__["Italian"]
  }); //listener for city

  $('#city').on('input', function () {
    checkData();
  }); //listeners for check-in/out

  $('#check_in').change(function () {
    checkData();
  });
  $('#check_out').change(function () {
    checkData();
  }); //people listener

  $('#people').change(function () {
    checkData();
  }); //services listener

  $('.service_checkbox').change(function () {
    checkData();
  }); //order by listener

  $('.order_by').click(function () {
    $('.order_by').removeClass('active');
    $(this).addClass('active');
    checkData();
  }); //start the search

  checkData();
})();
/**
 * Print current km radius
 * @param value
 */


function printKmRadius(value) {
  $('.km_radius').text(value + ' km');
}
/**
 * Print current range price
 * @param range
 */


function printRangePrice(range) {
  if (range[0] === range[1]) {
    $('.price_range').text('Euro ' + formatCurrencyLocale(range[0]));
  } else {
    $('.price_range').text('da Euro ' + formatCurrencyLocale(range[0]) + ' a Euro ' + formatCurrencyLocale(range[1]));
  }
}
/**
 * Format number to locale
 * @param value
 * @returns {string}
 */


function formatCurrencyLocale(value) {
  return value.toLocaleString('it-IT', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}
/**
 * Check data before sending request
 */


function checkData() {
  //need to check date field
  //jquery element
  var checkInElement = $('#check_in');
  var checkOutElement = $('#check_out'); //read check-in

  if (checkInElement.val() !== '') {
    //if check-in is selected, also check-out must be selected
    if (checkOutElement.val() === '') {
      checkOutElement.removeClass('is-invalid').addClass('is-invalid');
      return;
    } //check-in must be less than check-out


    if (MOMENT(checkInElement.val(), "DD-MM-YYYY").isSameOrAfter(MOMENT(checkOutElement.val(), "DD-MM-YYYY"))) {
      checkInElement.removeClass('is-invalid').addClass('is-invalid');
      return;
    }
  } //read check-out


  if (checkOutElement.val() !== '') {
    //if check-out is selected, also check-in must be selected
    if (checkInElement.val() === '') {
      checkInElement.removeClass('is-invalid').addClass('is-invalid');
      return;
    }
  } //send request with data


  checkOutElement.removeClass('is-invalid');
  checkInElement.removeClass('is-invalid'); //collect data for services

  var services = [];
  $('.service_checkbox:checked').each(function (e) {
    services.push($(this).val());
  }); //send request

  var checkIn = checkInElement.val();
  var checkOut = checkOutElement.val();
  var REQUEST_OBJECT = {
    'city_code': $('#city').val(),
    'check_in': checkIn === '' ? null : checkIn,
    'check_out': checkOut === '' ? null : checkOut,
    'people_count': $('#people').val(),
    'distance_radius': RADIUS_SLIDER.slider('getValue'),
    'price_range': PRICE_SLIDER.slider('getValue'),
    'services': services,
    'order_by': $('.order_by.active').data('value')
  };
  sendRequest(REQUEST_OBJECT);
}
/**
 * Send request to the server
 */


function sendRequest(requestData) {
  _search_mod__WEBPACK_IMPORTED_MODULE_5__["default"].sendRequest(requestData, function (data) {
    printData(data, false);
    printResultsCount(_search_mod__WEBPACK_IMPORTED_MODULE_5__["default"].total_results);

    if (_search_mod__WEBPACK_IMPORTED_MODULE_5__["default"].more_results) {
      attachListenerToScrollbar(true);
    }
  });
}
/**
 * Print total results count
 * @param count
 */


function printResultsCount(count) {
  $('.results_count').text(count);
}
/**
 * Print apartment cards after received data from server
 * @param data
 * @param appendToExistingData
 */


function printData(data, appendToExistingData) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4___default.a.compile($("#apartment-card-template").html());
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4___default.a.registerHelper('processAmount', function (options) {
    var amount = parseFloat(options.fn(this));
    return amount.toLocaleString('it-IT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  });
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4___default.a.registerHelper('processSale', function (options) {
    var index = options.fn(this);
    var salePrice = data[index].price_per_night - data[index].price_per_night * data[index].sale / 100;
    return salePrice.toLocaleString('it-IT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  });
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4___default.a.registerHelper('processDistance', function (options) {
    var distance = options.fn(this);
    return Math.trunc(distance);
  });

  if (appendToExistingData) {
    $('.results_wrapper').append(template(data));
  } else {
    $('.results_wrapper').html(template(data));
  }
}
/**
 * Attach lister to scrollbar in order to load more results if exist
 * @param attach
 */


function attachListenerToScrollbar(attach) {
  if (attach) {
    $(window).scroll(function () {
      if ($(window).scrollTop() + $(window).height() === $(document).height()) {
        attachListenerToScrollbar(false);
        loadMore();
      }
    });
  } else {
    $(window).off('scroll');
  }
}
/**
 * Laod more results from server
 */


function loadMore() {
  //show loading element
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_4___default.a.compile($("#loading-template").html());
  $('.results_wrapper').append(template());
  _search_mod__WEBPACK_IMPORTED_MODULE_5__["default"].loadMore(function (data) {
    //remove loading card
    $('.loading_card').remove();
    printData(data, true);

    if (_search_mod__WEBPACK_IMPORTED_MODULE_5__["default"].more_results) {
      attachListenerToScrollbar(true);
    }
  });
}

/***/ }),

/***/ 24:
/*!**************************************!*\
  !*** multi ./resources/js/search.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/search.js */"./resources/js/search.js");


/***/ })

},[[24,"/js/manifest","/js/vendor"]]]);