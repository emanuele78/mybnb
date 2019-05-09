import PROJECT_MODULE from "./app";
import Slider from 'bootstrap-slider/dist/bootstrap-slider';
import flatpickr from "flatpickr";
import {Italian} from "flatpickr/dist/l10n/it.js"
import Handlebars from 'handlebars/dist/cjs/handlebars';
import SEARCH_MODULE from "./search_mod";

const MOMENT = require('moment');
//initialize slider for distance radius
const RADIUS_SLIDER = $('#radius_slider').slider();
//initialize slider for price
const PRICE_SLIDER = $('#price_slider').slider();

/**
 * Entry point
 */
(function () {
    RADIUS_SLIDER.on('change', function (e) {
        printKmRadius(e.value.newValue);
    });
    PRICE_SLIDER.on('change', function (e) {
        printRangePrice(e.value.newValue);
    });
    //sliders listener
    RADIUS_SLIDER.slider().on('slideStop', function () {
        checkData();
    });
    PRICE_SLIDER.slider().on('slideStop', function () {
        checkData();
    });
    //print default value
    printKmRadius(RADIUS_SLIDER.slider('getValue'));
    printRangePrice(PRICE_SLIDER.slider('getValue'));
    //initialize flatpicker
    flatpickr('.flatpicker', {
        clickOpens: true,
        dateFormat: "d-m-Y",
        "locale": Italian
    });
    //listener for city
    $('#city').on('input', function () {
        checkData();
    });
    //listeners for check-in/out
    $('#check_in').change(function () {
        checkData();
    });
    $('#check_out').change(function () {
        checkData();
    });
    //people listener
    $('#people').change(function () {
        checkData();
    });
    //services listener
    $('.service_checkbox').change(function () {
        checkData();
    });
    //order by listener
    $('.order_by').click(function () {
        $('.order_by').removeClass('active');
        $(this).addClass('active');
        checkData();
    });
})();

/**
 * Print current km radius
 * @param value
 */
function printKmRadius(value) {
    $('.km_radius').text(value + ' km');
}

/**
 * Print current range price
 * @param range
 */
function printRangePrice(range) {
    if (range[0] === range[1]) {
        $('.price_range').text('Euro ' + formatCurrencyLocale(range[0]));
    } else {
        $('.price_range').text('da Euro ' + formatCurrencyLocale(range[0]) + ' a Euro ' + formatCurrencyLocale(range[1]));
    }
}

/**
 * Format number to locale
 * @param value
 * @returns {string}
 */
function formatCurrencyLocale(value) {
    return value.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

/**
 * Check data before sending request
 */
function checkData() {
    //need to check date field
    //jquery element
    let checkInElement = $('#check_in');
    let checkOutElement = $('#check_out');
    //read check-in
    if (checkInElement.val() !== '') {
        //if check-in is selected, also check-out must be selected
        if (checkOutElement.val() === '') {
            checkOutElement.removeClass('is-invalid').addClass('is-invalid');
            return;
        }
        //check-in must be less than check-out
        if (MOMENT(checkInElement.val(), "DD-MM-YYYY").isSameOrAfter(MOMENT(checkOutElement.val(), "DD-MM-YYYY"))) {
            checkInElement.removeClass('is-invalid').addClass('is-invalid');
            return;
        }
    }
    //read check-out
    if (checkOutElement.val() !== '') {
        //if check-out is selected, also check-in must be selected
        if (checkInElement.val() === '') {
            checkInElement.removeClass('is-invalid').addClass('is-invalid');
            return;
        }
    }
    //send request with data
    checkOutElement.removeClass('is-invalid');
    checkInElement.removeClass('is-invalid');
    //collect data for services
    let services = [];
    $('.service_checkbox:checked').each(function (e) {
        services.push($(this).val());
    });
    //send request
    let checkIn = checkInElement.val();
    let checkOut = checkOutElement.val();
    const REQUEST_OBJECT = {
        'city_code': $('#city').val(),
        'check_in': checkIn === '' ? null : checkIn,
        'check_out': checkOut === '' ? null : checkOut,
        'people_count': $('#people').val(),
        'distance_radius': RADIUS_SLIDER.slider('getValue'),
        'price_range': PRICE_SLIDER.slider('getValue'),
        'services': services,
        'order_by': $('.order_by.active').data('value')
    };
    sendRequest(REQUEST_OBJECT);
}

/**
 * Send request to the server
 */
function sendRequest(requestData) {
    SEARCH_MODULE.sendRequest(requestData, function (data) {
        printData(data, false);
        printResultsCount(SEARCH_MODULE.total_results);
        if (SEARCH_MODULE.more_results) {
            attachListenerToScrollbar(true);
        }
    });
}

/**
 * Print total results count
 * @param count
 */
function printResultsCount(count) {
    $('.results_count').text(count);
}

/**
 * Print apartment cards after received data from server
 * @param data
 * @param appendToExistingData
 */
function printData(data, appendToExistingData) {
    let template = Handlebars.compile($("#apartment-card-template").html());
    Handlebars.registerHelper('processAmount', function (options) {
        let amount = parseFloat(options.fn(this));
        return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    });
    Handlebars.registerHelper('processSale', function (options) {
        let index = options.fn((this));
        let salePrice = data[index].price_per_night - (data[index].price_per_night * data[index].sale / 100);
        return salePrice.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    });
    Handlebars.registerHelper('processDistance', function (options) {
        let distance = options.fn((this));
        return Math.trunc(distance);
    });
    if (appendToExistingData) {
        $('.results_wrapper').append(template(data));
    } else {
        $('.results_wrapper').html(template(data));
    }
}

/**
 * Attach lister to scrollbar in order to load more results if exist
 * @param attach
 */
function attachListenerToScrollbar(attach) {
    if (attach) {
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() === $(document).height()) {
                attachListenerToScrollbar(false);
                loadMore();
            }
        });
    } else {
        $(window).off('scroll');
    }
}

/**
 * Laod more results from server
 */
function loadMore() {
    //show loading element
    let template = Handlebars.compile($("#loading-template").html());
    $('.results_wrapper').append(template());
    SEARCH_MODULE.loadMore(function (data) {
        //remove loading card
        $('.loading_card').remove();
        printData(data, true);
        if (SEARCH_MODULE.more_results) {
            attachListenerToScrollbar(true);
        }
    });
}