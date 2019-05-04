(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/show_apartment"],{

/***/ "./resources/js/show_apartment.js":
/*!****************************************!*\
  !*** ./resources/js/show_apartment.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _load_map_mod__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./load_map_mod */ "./resources/js/load_map_mod.js");
/* harmony import */ var _load_address_mod__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./load_address_mod */ "./resources/js/load_address_mod.js");
/* harmony import */ var _send_message_mod__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./send_message_mod */ "./resources/js/send_message_mod.js");



/**
 * Load map and address for the apartment async
 */

(function () {
  var APARTMENT_SLUG = $('#tomtom_map').data().apartment;
  _load_map_mod__WEBPACK_IMPORTED_MODULE_0__["default"].getMap(APARTMENT_SLUG, function (response) {
    if (response.success) {
      $('.loading_map').hide();
      $('#marker').show();
      $('#tomtom_map').attr('src', "data:image/png;charset=binary;base64," + response.data);
    } else {
      $('.loading_map').html('N/D');
    }
  });
  _load_address_mod__WEBPACK_IMPORTED_MODULE_1__["default"].getAddress(APARTMENT_SLUG, function (response) {
    if (response.success) {
      $('#apartment_address').text(formatAddress(response.data));
    } else {
      $('#apartment_address').text('Indirizzo non disponibile');
    }
  });

  function formatAddress(data) {
    var formatted_address = [];

    if (!isEmpty(data.streetName)) {
      formatted_address.push(data.streetName);
    }

    if (!isEmpty(data.municipality)) {
      formatted_address.push(data.municipality);
    }

    if (!isEmpty(data.postal_code)) {
      formatted_address.push('(' + data.postal_code + ')');
    }

    if (!isEmpty(data.province)) {
      formatted_address.push(data.province);
    }

    return formatted_address.join(', ');
  }

  function isEmpty(value) {
    return !value || value.length === 0;
  }
})();
/**
 * Listener for sending message button
 */


$('#submit_message').click(function (e) {
  e.preventDefault();
  var textArea = $('#body');

  if (textArea.val().length < 10) {
    textArea.addClass('is-invalid');
    return;
  }

  textArea.removeClass('is-invalid');
  var apartment = $("#message_apartment_slug").val();
  $(this).attr('disabled', 'disabled');
  _send_message_mod__WEBPACK_IMPORTED_MODULE_2__["default"].sendMessageToApartment(apartment, textArea.val(), $('meta[name="csrf-token"]').attr('content'), function (response) {
    if (response.success) {
      $('#message_wrapper').removeClass('alert-danger');
      $('#message_wrapper').addClass('alert-success');
      $('#message_response').text('Messaggio inviato correttamente');
      textArea.val('');
    } else {
      $('#message_wrapper').removeClass('alert-success');
      $('#message_wrapper').addClass('alert-danger');
      $('#message_response').text('Errore durante l\'invio del messaggio');
    }

    $('#submit_message').removeAttr('disabled');
  });
});
/**
 * Listener for booking button
 */

$('#book_apartment').click(function (e) {
  e.preventDefault();
  var checkIn = $('#check_in').val();
  var checkOut = $('#check_out').val();
  window.location.href = $(this).attr('href') + '?check-in=' + checkIn + '&check-out=' + checkOut;
});

/***/ }),

/***/ 9:
/*!**********************************************!*\
  !*** multi ./resources/js/show_apartment.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/show_apartment.js */"./resources/js/show_apartment.js");


/***/ })

},[[9,"/js/manifest","/js/vendor"]]]);