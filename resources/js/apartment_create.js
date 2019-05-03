import PROJECT_MODULE from './app.js';
import GEO_MODULE from "./geo_search_mod";
import CALENDAR_MODULE from "./calendar_mod";
import Handlebars from 'handlebars/dist/cjs/handlebars'

attachListeners();
initializeReservedDaysCalendar();

/**
 * Listener for address search button
 */
$('#locality_search_button').click(function (e) {
    e.preventDefault();
    let userInput = $('#address').val().trim();
    if (userInput.length < 5) {
        $('#address').removeClass('is-invalid').addClass('is-invalid');
        return;
    }
    $('#address').removeClass('is-invalid');
    //show loading spinner
    $('.waiting.waiting_address').show();
    //hide old results
    $('.address_search_results').removeClass('collapse').addClass('collapse');
    GEO_MODULE.searchAddress(userInput, $('meta[name="csrf-token"]').attr('content'), function (result) {
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
        let template = Handlebars.compile($("#no-results-template").html());
        $('.address_search_results_content').html(template());
    } else {
        let template = Handlebars.compile($("#address-search-results-template").html());
        $('.address_search_results_content').html(template(data.results));
        attachListnerOnResultedAddress();
    }
    $('.address_search_results').removeClass('collapse');
}

/**
 * Listener for single address in list
 */
function attachListnerOnResultedAddress() {
    $('.address_item').click(function (e) {
        e.preventDefault();
        //active seleceted item
        $('.address_item').removeClass('active');
        $(this).addClass('active');
        //set value in hidden address fields
        const LAT = $(this).data('lat');
        const LNG = $(this).data('lng');
        $('.address_input[name=address_lat]').val(LAT);
        $('.address_input[name=address_lng]').val(LNG);
        //load map
        loadMap(LAT, LNG);
    });
}

/**
 * Load map for selected address
 * @param lat
 * @param lng
 */
function loadMap(lat, lng) {
    GEO_MODULE.searchMap(lat, lng, $('meta[name="csrf-token"]').attr('content'), function (result) {
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
    const SALE_INPUT_ELEMENT = $('#sale');
    const PRICE_INPUT_ELEMENT = $('#price-per-night');

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
        keypress: function (e) {
            if (!validateFloatKeyPress(PRICE_INPUT_ELEMENT[0], e)) {
                e.preventDefault();
                e.stopPropagation();
            }
        },
        keyup: function () {
            printNewPrice();
        }
    });
    SALE_INPUT_ELEMENT.on({
        keypress: function (e) {
            if (!isKeyAllowed(e)) {
                e.preventDefault();
                e.stopPropagation();
            }
        },
        keyup: function () {
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
        let inputElement = $('#new_service_input');
        let userInput = inputElement.val().trim().toLowerCase();
        //service with name length less than 3 chars not allowed
        if (userInput.length < 3) {
            inputElement.removeClass('is-invalid').addClass('is-invalid');
            return;
        }
        //check if name already exist
        if (serviceExists(userInput)) {
            inputElement.removeClass('is-invalid').addClass('is-invalid');
            return;
        }
        inputElement.removeClass('is-invalid');
        addService(userInput);
        inputElement.val('');
        //scroll to bottom where new service was added
        let container = $('.upgrades_container');
        container.scrollTop(container.height());
    });
}

/**
 * Add new service
 */
function addService(userInput) {
    let template = Handlebars.compile($("#new-service-template").html());
    $('.upgrades_container').append(template({'service_name': userInput}));
}

/**
 * Check if a service name already exist
 */
function serviceExists(userInput) {
    let exists = false;
    $.each($('.service'), function () {
        exists = $(this).val() === userInput ? true : exists;
    });
    return exists;
}

/**
 * Calc and print the sale price
 */
function printNewPrice() {
    let sale = parseInt($('#sale').val());
    let price = parseInt($('#price-per-night').val());
    if (sale > 0 && price > 0) {
        let newPrice = price - (sale * price / 100);
        $('#sale-price').val(newPrice.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }
}

/**
 * Only numbers allowed
 * @param event
 * @returns {boolean}
 */
function isKeyAllowed(event) {
    let k = event.which || event.keyCode;
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
    let charCode = (evt.which) ? evt.which : event.keyCode;
    let number = el.value.split('.');
    if (charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    //just one dot
    if (number.length > 1 && charCode === 46) {
        return false;
    }
    //get the caret position
    let caratPos = getSelectionStart(el);
    let dotPos = el.value.indexOf(".");
    return !(caratPos > dotPos && dotPos > -1 && (number[1].length > 1));
}

/**
 * Helper function for caret position
 * Credits goes to StackOverflow
 * @param o
 * @returns {*}
 */
function getSelectionStart(o) {
    if (o.createTextRange) {
        let r = document.selection.createRange().duplicate();
        r.moveEnd('character', o.value.length);
        if (r.text === '') {
            return o.value.length;
        }
        return o.value.lastIndexOf(r.text)
    }
    return o.selectionStart
}

/**
 * Initialize calendar
 * @param apartmentsWithBookings
 */
function initializeReservedDaysCalendar(apartmentsWithBookings) {
    CALENDAR_MODULE.initializeToElement($('#reserved_days_calendar')[0], function (date) {
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
    if (!CALENDAR_MODULE.isReserved(date)) {
        CALENDAR_MODULE.reserve(date);
    } else {
        CALENDAR_MODULE.free(date);
    }
    printReservedDays(CALENDAR_MODULE.reservedDays());
}

/**
 * Print the reserved days list
 * @param data
 */
function printReservedDays(data) {
    let template = Handlebars.compile($("#reserved-days-template").html());
    $('#reserved_days_list').html(template(data));
    $('.reserved_day').off().dblclick(function () {
        toggleReservedDay($(this).data('value'));
    });
}