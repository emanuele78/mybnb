(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/threads_index"],{

/***/ "./resources/js/threads_index.js":
/*!***************************************!*\
  !*** ./resources/js/threads_index.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__);



(function () {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].messagesEndpoint;
  $.ajax(url, {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'show_by': $('.dropdown-item.active').data('type')
    },
    success: function success(data) {
      console.log(data);
    },
    error: function error(e) {
      console.log(e);
    }
  });
})();

/***/ }),

/***/ 13:
/*!*********************************************!*\
  !*** multi ./resources/js/threads_index.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/threads_index.js */"./resources/js/threads_index.js");


/***/ })

},[[13,"/js/manifest","/js/vendor"]]]);