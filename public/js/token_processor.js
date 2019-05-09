(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/token_processor"],{

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

  if (!$('#agreement_check').is(':checked')) {
    emailElement.addClass('is-invalid');
    $('.error_message').text('Devi accettare l\'accordo di licenza per richiedere un token');
    return;
  }

  var emailValue = emailElement.val();

  if (isValidEmail(emailValue)) {
    //do ajax request
    emailElement.removeClass('is-invalid');
    requestToken(emailValue, $(this), $('#loading-element'));
  } else {
    //invalid email
    emailElement.addClass('is-invalid');
    $('.error_message').text('Controlla l\'e-mail inserita');
  }
});
/**
 * Perform ajax call to request a new token for the provided email address
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
 * Checks if the passed string is a valid email address - from StackOverflow
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