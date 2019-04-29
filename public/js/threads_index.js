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


/**
 * Entry point
 */

sendRequest();
registerListenerForVisualizationDropdown();
/**
 * Send request to get data for own apartments | other apartments threads
 */

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
      if ($('.dropdown-item.active').data('type') === 'my_apartments') {
        $('.main_message_title').text('Messaggi per i tuoi appartamenti');
      } else {
        $('.main_message_title').text('Messaggi per altri appartamenti');
      }

      attachDeleteButtonsListeners();
    }
  });
}
/**
 * Listener for dropdown
 */


function registerListenerForVisualizationDropdown() {
  $('.dropdown-item').click(function (e) {
    e.preventDefault();
    $('.dropdown-item').removeClass('active');
    $(this).addClass('active');
    sendRequest();
  });
}
/**
 * Listener for accordion toggling
 */


function registerListenerForAccordion() {
  $('.toggle_text').off();
  $('.toggle_text').click(function () {
    $(this).text($(this).text() === 'Mostra conversazioni' ? 'Nascondi conversazioni' : 'Mostra conversazioni');
  });
}
/**
 * Print the data received by the server
 * @param data
 */


function printResults(data) {
  if ($('.dropdown-item.active').data('type') === 'my_apartments') {
    generateHtml(data, $("#own-apartments-template"));
    registerListenerForAccordion();
  } else {
    generateHtml(data, $("#other-apartments-template"));
  }
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
  $('.content_wrapper').html(template(data));
}
/**
 * Attach listeners for delete buttons in
 */


function attachDeleteButtonsListeners() {
  $('.delete_other_apartments_thread').off().click(function () {
    var itemToBeRemoved = $(this);
    deleteThread($(this).attr('data-thread'), function () {
      //remove the elementdata
      $(itemToBeRemoved).parents('.single_apartment').remove();
    });
  });
  $('.delete_my_apartments_thread').off().click(function () {
    var thread = $(this).attr('data-thread');
    deleteThread(thread, function () {
      //remove the element inside the accordion
      $('#thread_section_' + thread).remove(); //check for apartments without threads

      removeApartmentWithoutThreads();
    });
  });
}
/**
 * Send request to delete the selected thread
 */


function deleteThread(thread, successCallback) {
  var url = _app_js__WEBPACK_IMPORTED_MODULE_0__["default"].threadEndpoint.replace('{thread}', thread);
  $.ajax(url, {
    method: 'DELETE',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success() {
      successCallback();
    },
    error: function error(e) {
      console.log(e);
    }
  });
}
/**
 * Remove apartment cards without threads
 */


function removeApartmentWithoutThreads() {
  $('.single_apartment').each(function () {
    if ($(this).find('.apartment_threads_section').children().length === 0) {
      $(this).remove();
    }
  });
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