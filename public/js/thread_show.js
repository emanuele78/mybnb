(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/thread_show"],{

/***/ "./resources/js/thread_show.js":
/*!*************************************!*\
  !*** ./resources/js/thread_show.js ***!
  \*************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _send_message_mod__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./send_message_mod */ "./resources/js/send_message_mod.js");



sendRequest();

function sendRequest() {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].threadEndpoint.replace('{thread}', $('#current_apartment').data('thread'));
  $.ajax(url, {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      printResults(data);
    },
    error: function error(e) {
      console.log(e);
    },
    complete: function complete() {
      //scroll to bottom on thread body when it is loaded
      $('.custom_container_body').scrollTop($('.custom_container_body').height());
    }
  });
}

function printResults(data) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile($('#message-template').html());
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.registerHelper('ifCond', function (message, options) {
    if ('unreaded' in message) {
      return options.fn(this);
    }

    return options.inverse(this);
  });
  handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.registerHelper('senderName', function (sender) {
    return sender === data.thread_for_user ? 'Tu' : sender;
  });
  $('.custom_container_body').html(template(data.messages));
}
/**
 * Listener for sending message button
 */


$('#submit_message').click(function (e) {
  e.preventDefault();
  var textArea = $('#body');

  if (textArea.val().trim().length === 0) {
    textArea.addClass('is-invalid');
    return;
  }

  textArea.removeClass('is-invalid');
  $(this).attr('disabled', 'disabled');
  _send_message_mod__WEBPACK_IMPORTED_MODULE_2__["default"].sendMessageToThread($('#current_apartment').data('thread'), textArea.val().trim(), $('meta[name="csrf-token"]').attr('content'), function (response) {
    if (response.success) {
      textArea.val('');
      sendRequest();
    } else {
      textArea.addClass('is-invalid');
    }

    $('#submit_message').removeAttr('disabled');
  });
});
/**
 * Listener for delete button
 */

$('#delete_button').click(function () {
  //show confirmation message
  $('#delete_message').modal('show');
});
/**
 * Listener for modal delete button
 */

$('#confirm_delete_button').click(function () {
  $('#delete_message').modal('hide');
});

/***/ }),

/***/ 14:
/*!*******************************************!*\
  !*** multi ./resources/js/thread_show.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/thread_show.js */"./resources/js/thread_show.js");


/***/ })

},[[14,"/js/manifest","/js/vendor"]]]);