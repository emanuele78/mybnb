(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/index"],{

/***/ "./resources/js/index.js":
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flatpickr */ "./node_modules/flatpickr/dist/flatpickr.js");
/* harmony import */ var flatpickr__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flatpickr__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flatpickr/dist/l10n/it.js */ "./node_modules/flatpickr/dist/l10n/it.js");
/* harmony import */ var flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3__);




/**
 * Flatpicker initialization
 */

flatpickr__WEBPACK_IMPORTED_MODULE_2___default()('.flatpicker', {
  clickOpens: true,
  dateFormat: "d-m-Y",
  "locale": flatpickr_dist_l10n_it_js__WEBPACK_IMPORTED_MODULE_3__["Italian"]
});
/**
 * Call endpoint for get cities list in order to fill the datalist in the search bar
 */

(function () {
  $.ajax(_app_js__WEBPACK_IMPORTED_MODULE_0__["default"].citiesEndpoint, {
    method: 'GET',
    success: function success(data) {
      populateDatalist(data);
    },
    error: function error() {
      console.log('Unable to load cities');
    }
  });

  function populateDatalist(data) {
    var template = $('#cities_list_template').html();
    var compiled = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile(template);
    $('#cities_list').html(compiled(data));
  }
})();

/***/ }),

/***/ 2:
/*!*************************************!*\
  !*** multi ./resources/js/index.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/index.js */"./resources/js/index.js");


/***/ })

},[[2,"/js/manifest","/js/vendor"]]]);