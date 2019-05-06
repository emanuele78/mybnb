(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/apartment_create"],{

/***/ "./resources/js/apartment_create.js":
/*!******************************************!*\
  !*** ./resources/js/apartment_create.js ***!
  \******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.js */ "./resources/js/app.js");
/* harmony import */ var _geo_search_mod__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./geo_search_mod */ "./resources/js/geo_search_mod.js");
/* harmony import */ var _calendar_mod__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./calendar_mod */ "./resources/js/calendar_mod.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! handlebars/dist/cjs/handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _load_address_mod__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./load_address_mod */ "./resources/js/load_address_mod.js");





attachListeners();
initializeReservedDaysCalendar();
initializeAddress();
/**
 * Listener for address search button
 */

$('#locality_search_button').click(function (e) {
  e.preventDefault();
  var userInput = $('#address').val().trim();

  if (userInput.length < 5) {
    $('#address').removeClass('is-invalid').addClass('is-invalid');
    return;
  }

  $('#address').removeClass('is-invalid'); //show loading spinner

  $('.waiting.waiting_address').show(); //hide old results

  $('.address_search_results').removeClass('collapse').addClass('collapse');
  _geo_search_mod__WEBPACK_IMPORTED_MODULE_1__["default"].searchAddress(userInput, $('meta[name="csrf-token"]').attr('content'), function (result) {
    $('.waiting.waiting_address').hide();

    if (result.success) {
      showAddresses(result.data);
    } else {
      showAddresses(null);
    }
  });
});
/**
 * Show the addresses list
 * @param data
 */

function showAddresses(data) {
  if (data === null) {
    var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3___default.a.compile($("#no-results-template").html());
    $('.address_search_results_content').html(template());
  } else {
    var _template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3___default.a.compile($("#address-search-results-template").html());

    $('.address_search_results_content').html(_template(data.results));
    attachListenersOnResultedAddresses();
  }

  $('.address_search_results').removeClass('collapse');
}
/**
 * Listener for single address in list
 */


function attachListenersOnResultedAddresses() {
  $('.address_item').off().click(function (e) {
    e.preventDefault(); //active seleceted item

    $('.address_item').removeClass('active');
    $(this).addClass('active'); //set value in hidden address fields

    var LAT = $(this).data('lat');
    var LNG = $(this).data('lng');
    $('.address_input[name=address_lat]').val(LAT);
    $('.address_input[name=address_lng]').val(LNG); //load map

    loadMap(LAT, LNG);
  });
}
/**
 * Load map for selected address
 * @param lat
 * @param lng
 */


function loadMap(lat, lng) {
  _geo_search_mod__WEBPACK_IMPORTED_MODULE_1__["default"].searchMap(lat, lng, $('meta[name="csrf-token"]').attr('content'), function (result) {
    $('.waiting.waiting_address').hide();
    $('#marker').removeClass('collapse');

    if (result.success) {
      $('#tomtom_map').attr('src', "data:image/png;charset=binary;base64," + result.data);
    } else {
      $('#marker').html('N/D');
    }
  });
}
/**
 * Listeners for numeric value inputs
 */


function attachListeners() {
  var SALE_INPUT_ELEMENT = $('#sale');
  var PRICE_INPUT_ELEMENT = $('#price-per-night');
  $('#max-stay').keypress(function (e) {
    if (!isKeyAllowed(e)) {
      e.preventDefault();
      e.stopPropagation();
    }
  });
  $('#square-meters').keypress(function (e) {
    if (!isKeyAllowed(e)) {
      e.preventDefault();
      e.stopPropagation();
    }
  });
  PRICE_INPUT_ELEMENT.on({
    keypress: function keypress(e) {
      if (!validateFloatKeyPress(PRICE_INPUT_ELEMENT[0], e)) {
        e.preventDefault();
        e.stopPropagation();
      }
    },
    keyup: function keyup() {
      printNewPrice();
    }
  });
  SALE_INPUT_ELEMENT.on({
    keypress: function keypress(e) {
      if (!isKeyAllowed(e)) {
        e.preventDefault();
        e.stopPropagation();
      }
    },
    keyup: function keyup() {
      if (parseInt(SALE_INPUT_ELEMENT.val()) > 99) {
        $('#sale').removeClass('is-invalid').addClass('is-invalid');
        $('#sale-price').val('');
      } else {
        $('#sale').removeClass('is-invalid');
        printNewPrice();
      }
    }
  });
  $('.service_price').keypress(function (e) {
    if (!validateFloatKeyPress($(this)[0], e)) {
      e.preventDefault();
      e.stopPropagation();
    }
  });
  $('#add_service').click(function (e) {
    e.preventDefault();
    var inputElement = $('#new_service_input');
    var userInput = inputElement.val().trim().toLowerCase(); //service with name length less than 3 chars not allowed

    if (userInput.length < 3) {
      inputElement.removeClass('is-invalid').addClass('is-invalid');
      return;
    } //check if name already exist


    if (serviceExists(userInput)) {
      inputElement.removeClass('is-invalid').addClass('is-invalid');
      return;
    }

    inputElement.removeClass('is-invalid');
    addService(userInput);
    inputElement.val(''); //scroll to bottom where new service was added

    var container = $('.upgrades_container');
    container.scrollTop(container.height());
  }); //listener for open image fake button

  $('.open_input_file').click(function () {
    $('.custom_file_input[data-index="' + $(this).data('index') + '"]').click();
  }); //listener for input file buttons

  $('.custom_file_input').on('input', function () {
    readFile($(this));
  });
}
/**
 * Reading the file selected by user
 * @param inputElement
 */


function readFile(inputElement) {
  if (inputElement[0].files && inputElement[0].files[0]) {
    var fileReader = new FileReader();

    fileReader.onload = function (e) {
      if (inputElement.data('index') == 0) {
        previewImage(inputElement.data('index'), 'Principale', e.target.result);
      } else {
        previewImage(inputElement.data('index'), 'Secondaria ' + inputElement.data('index'), e.target.result);
      }

      attachRemoveImageButtons();
    };

    fileReader.readAsDataURL(inputElement[0].files[0]);
    $('.input_file_label[data-index="' + inputElement.data('index') + '"] > .input_file_label_text').text(inputElement[0].files[0].name);
  }
}
/**
 * Attach listeners to remove images
 */


function attachRemoveImageButtons() {
  //removing image button listener
  $('.image_frame .remove_image').off().click(function () {
    //remove the element
    var elementIndex = $(this).data('remove');
    $('.image_frame_' + elementIndex).remove(); //change label value

    $('.input_file_label[data-index="' + elementIndex + '"] > .input_file_label_text').text('Scegli immagine');
  });
}
/**
 * Preview the image through handlebars template
 * @param image_index
 * @param overlay_text
 * @param image_data
 */


function previewImage(image_index, overlay_text, image_data) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3___default.a.compile($("#image-template").html());
  $('.image_container').append(template({
    'image_index': image_index,
    'overlay_text': overlay_text,
    'image_data': image_data
  }));
}
/**
 * Add new service
 */


function addService(userInput) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3___default.a.compile($("#new-service-template").html());
  $('.upgrades_container').append(template({
    'service_name': userInput
  }));
}
/**
 * Check if a service name already exist
 */


function serviceExists(userInput) {
  var exists = false;
  $.each($('.service'), function () {
    exists = $(this).val() === userInput ? true : exists;
  });
  return exists;
}
/**
 * Calc and print the sale price
 */


function printNewPrice() {
  var sale = parseInt($('#sale').val());
  var price = parseInt($('#price-per-night').val());

  if (sale > 0 && price > 0) {
    var newPrice = price - sale * price / 100;
    $('#sale-price').val(newPrice.toLocaleString('it-IT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }));
  }
}
/**
 * Only numbers allowed
 * @param event
 * @returns {boolean}
 */


function isKeyAllowed(event) {
  var k = event.which || event.keyCode;
  return k >= 48 && k <= 57;
}
/**
 * Only one dot allowed and only 2 decimal digits
 * Credits goes to StackOverflow
 * @param el
 * @param evt
 * @returns {boolean}
 */


function validateFloatKeyPress(el, evt) {
  var charCode = evt.which ? evt.which : event.keyCode;
  var number = el.value.split('.');

  if (charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  } //just one dot


  if (number.length > 1 && charCode === 46) {
    return false;
  } //get the caret position


  var caratPos = getSelectionStart(el);
  var dotPos = el.value.indexOf(".");
  return !(caratPos > dotPos && dotPos > -1 && number[1].length > 1);
}
/**
 * Helper function for caret position
 * Credits goes to StackOverflow
 * @param o
 * @returns {*}
 */


function getSelectionStart(o) {
  if (o.createTextRange) {
    var r = document.selection.createRange().duplicate();
    r.moveEnd('character', o.value.length);

    if (r.text === '') {
      return o.value.length;
    }

    return o.value.lastIndexOf(r.text);
  }

  return o.selectionStart;
}
/**
 * Initialize calendar
 * @param apartmentsWithBookings
 */


function initializeReservedDaysCalendar(apartmentsWithBookings) {
  _calendar_mod__WEBPACK_IMPORTED_MODULE_2__["default"].initializeToElement($('#reserved_days_calendar')[0], function (date) {
    toggleReservedDay(date);
  });
  $.each($('.reserved_day'), function () {
    toggleReservedDay($(this).data('value'));
  });
}
/**
 * Set/unset reserved day
 * @param date
 */


function toggleReservedDay(date) {
  if (!_calendar_mod__WEBPACK_IMPORTED_MODULE_2__["default"].isReserved(date)) {
    _calendar_mod__WEBPACK_IMPORTED_MODULE_2__["default"].reserve(date);
  } else {
    _calendar_mod__WEBPACK_IMPORTED_MODULE_2__["default"].free(date);
  }

  printReservedDays(_calendar_mod__WEBPACK_IMPORTED_MODULE_2__["default"].reservedDays());
}
/**
 * Print the reserved days list
 * @param data
 */


function printReservedDays(data) {
  var template = handlebars_dist_cjs_handlebars__WEBPACK_IMPORTED_MODULE_3___default.a.compile($("#reserved-days-template").html());
  $('#reserved_days_list').html(template(data));
  $('.reserved_day').off().dblclick(function () {
    toggleReservedDay($(this).data('value'));
  });
}
/**
 * In case of editing, the address need to be preload from server
 */


function initializeAddress() {
  var apartmentAddressElement = $('.address_item'); //only for updating

  if (apartmentAddressElement.length) {
    _load_address_mod__WEBPACK_IMPORTED_MODULE_4__["default"].getAddress(apartmentAddressElement.data('apartment'), function (response) {
      if (response.success) {
        apartmentAddressElement.text(response.data.full_address);
        attachListenersOnResultedAddresses();
        apartmentAddressElement.click();
      }
    });
  }
}

/***/ }),

/***/ 19:
/*!************************************************!*\
  !*** multi ./resources/js/apartment_create.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/emanuelemazzante/WorkingDirectory/Esercizi_Boolean/apache_default_portfolio/mybnb/resources/js/apartment_create.js */"./resources/js/apartment_create.js");


/***/ })

},[[19,"/js/manifest","/js/vendor"]]]);