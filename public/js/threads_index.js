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


sendRequest();
registerListenerForVisualizationDropdown();

function sendRequest() {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].messagesDashboardEndpoint;
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
      if ($('.dropdown-item.active').data('type') === 'my_apartment') {
        $('.main_message_title').text('Messaggi per i tuoi appartamenti');
      } else {
        $('.main_message_title').text('Messaggi per altri appartamenti');
      }
    }
  });
}

function registerListenerForVisualizationDropdown() {
  $('.dropdown-item').click(function (e) {
    e.preventDefault();
    $('.dropdown-item').removeClass('active');
    $(this).addClass('active');
    sendRequest();
  });
}

function registerListenerForAccordion() {
  $('.toggle_text').off();
  $('.toggle_text').click(function () {
    $(this).text($(this).text() === 'Mostra conversazioni' ? 'Nascondi conversazioni' : 'Mostra conversazioni');
  });
}

function printResults(data) {
  if ($('.dropdown-item.active').data('type') === 'my_apartment') {
    generateHtml(data, $("#own-apartments-template"));
    registerListenerForAccordion();
  } else {
    generateHtml(data, $("#other-apartments-template"));
  }
}

function printNoResults() {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile($("#no-results-template").html());
  $('.content_wrapper').html(template());
}

function generateHtml(data, templateElement) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile(templateElement.html());
  $('.content_wrapper').html(template(data));
}

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