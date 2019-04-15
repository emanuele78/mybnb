(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/token_processor"],{

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");
/**
 * Declaring differents endpoint for development and production
 */


var LOCAL_PORT = 8000;
var PROJECT_CONSTANTS = {
  citiesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/cities',
  tokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/tokens',
  activationTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/tokens',
  apartmentAvailabilityEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/'
};

if (false) {}

/* harmony default export */ __webpack_exports__["default"] = (PROJECT_CONSTANTS);

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.Popper = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js")["default"];
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

  __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {// console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/***/ }),

/***/ "./resources/js/token_processor.js":
/*!*****************************************!*\
  !*** ./resources/js/token_processor.js ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");

/**
 * Listener for request token button
 */

$('#request_token_button').click(function (e) {
  e.preventDefault();
  var emailElement = $('#email');
  var emailValue = emailElement.val();

  if (isValidEmail(emailValue)) {
    //do ajax request
    emailElement.removeClass('is-invalid');
    requestToken(emailValue, $(this), $('#loading-element'));
  } else {
    emailElement.addClass('is-invalid');
  }
});
/**
 * Does an ajax call to request a new token for the provided email address
 * @param email
 * @param elementToDisable
 * @param loadingElement
 */

function requestToken(email, elementToDisable, loadingElement) {
  $.ajax(_app_js__WEBPACK_IMPORTED_MODULE_0__["default"].tokenEndpoint, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function beforeSend() {
      loadingElement.collapse('show');
      elementToDisable.attr('disabled', 'disabled');
    },
    success: function success() {
      $('#card-loading').html('Il token è stato inviato');
    },
    data: {
      email: email
    },
    error: function error() {
      elementToDisable.removeAttr('disabled');
      $('#card-loading').html('Indirizzo e-mail non valido');
    }
  });
}
/**
 * Checks if the passed string is a valid email address
 * @param email
 * @returns {boolean}
 */


function isValidEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
/**
 * Listener for the activate token button
 */


$('#activate_token_button').click(function (e) {
  e.preventDefault();
  var tokenInput = $('#token_code');

  if ($.trim(tokenInput.val()) === '') {
    tokenInput.addClass('is-invalid');
  } else {
    $('#activation_form').attr('action', _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].activationTokenEndpoint + '/' + tokenInput.val());
    $('#activation_form').submit();
  }
});

/***/ }),

/***/ 1:
/*!***********************************************!*\
  !*** multi ./resources/js/token_processor.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/token_processor.js */"./resources/js/token_processor.js");


/***/ })

},[[1,"/js/manifest","/js/vendor"]]]);