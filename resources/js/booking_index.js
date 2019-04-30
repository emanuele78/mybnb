import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'
import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import '../../node_modules/@fullcalendar/core/main.css';
import '../../node_modules/@fullcalendar/daygrid/main.css';
import itLocale from '@fullcalendar/core/locales/it';
import MODAL_INFO_MODULE from "./modal_info_mod";

let moment = require('moment');

/**
 * Entry point
 */
sendRequest();
registerListenerForDropdowns();

/**
 * Send request to get data for own bookings | other apartments bookings
 */
function sendRequest() {
    let url = PROJECT_MODULE.bookingListEndpoint;
    $.ajax(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'show_by': $('.dropdown_show.active').data('show'),
            'filter': $('.dropdown_filter.active').data('filter'),
        },
        success: function (data) {
            if (data.length) {
                printResults(data);
            } else {
                printNoResults();
            }
        },
        error: function (e) {
            console.log(e);
        },
        complete: function () {
            if ($('.dropdown_show.active').data('show') === 'my_apartments_bookings') {
                $('.main_title').text('Prenotazioni effettuate ai tuoi appartamenti')
            } else if ($('.dropdown_show.active').data('show') === 'other_apartments_bookings') {
                $('.main_title').text('Prenotazioni effettuate ad altri appartamenti')
            } else {
                $('.main_title').text('Prenotazioni effettuate ad altri appartamenti (in sospeso)')
            }
        }
    });
}

/**
 * Listener for dropdowns
 */
function registerListenerForDropdowns() {
    $('.dropdown_filter').click(function (e) {
        e.preventDefault();
        $('.dropdown_filter').removeClass('active');
        $(this).addClass('active');
        sendRequest();
    });
    $('.dropdown_show').click(function (e) {
        e.preventDefault();
        $('.dropdown_show').removeClass('active');
        $(this).addClass('active');
        sendRequest();
    });
}

/**
 * Listener for accordion toggling
 */
function registerListenersForAccordion() {
    $('.expand_booking_list').off();
    $('.expand_booking_list').click(function () {
        $(this).text($(this).text() === 'Mostra elenco prenotazioni' ? 'Nascondi elenco prenotazioni' : 'Mostra elenco prenotazioni');
    });
    $('.expand_calendar').off();
    $('.expand_calendar').click(function () {
        $(this).text($(this).text() === 'Mostra calendario prenotazioni' ? 'Nascondi calendario prenotazioni' : 'Mostra calendario prenotazioni');
    });
}

/**
 * Print the data received by the server
 * @param data
 */
function printResults(data) {
    if ($('.dropdown_show.active').data('show') === 'my_apartments_bookings') {
        generateHtml(data, $("#own-apartments-template"));
        initializeCalendarGrid(data);
    } else {
        generateHtml(data, $("#other-apartments-template"));
    }
    registerListenersForAccordion();
}

/**
 * Initialize a calendar grid for each apartment
 * @param apartmentsWithBookings
 */
function initializeCalendarGrid(apartmentsWithBookings) {
    for (let apartmentWithBookings of apartmentsWithBookings) {
        let bookings = [];
        for (let booking of apartmentWithBookings.bookings) {
            bookings.push(
                {
                    id: booking.booking_reference,
                    title: booking.user_fullname,
                    start: moment(booking.check_in, "DD-MM-YYYY").format('YYYY-MM-DD'),
                    end: moment(booking.check_out, "DD-MM-YYYY").add(1, 'days').format('YYYY-MM-DD')
                }
            );
        }
        new Calendar($('#calendar-' + apartmentWithBookings.apartment_slug)[0], {
            plugins: [dayGridPlugin],
            defaultView: 'dayGridMonth',
            height: 500,
            locale: itLocale,
            events: bookings,
            eventClick: function (info) {
                showBookingInfo(apartmentsWithBookings, info.event.id);
            }
        }).render();
    }
}

/**
 * Show info of the given booking in a modal view
 * @param apartmentsWithBookings
 * @param reference
 */
function showBookingInfo(apartmentsWithBookings, reference) {
    console.log(apartmentsWithBookings);
    for (let apartmentWithBookings of apartmentsWithBookings) {
        for (let booking of apartmentWithBookings.bookings) {
            if (booking.booking_reference === reference) {
                showModal(booking);
                return;
            }
        }
    }
}

/**
 * Show the given booking on a modal view
 * @param booking
 */
function showModal(booking) {
    console.log(booking);
    let template = Handlebars.compile($("#info-booking-template").html());
    Handlebars.registerHelper('processAmount', function (options) {
        let amount = parseFloat(options.fn(this));
        return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    });
    $('#info_booking_content').html(template(booking));
    MODAL_INFO_MODULE.showInfoModal(function () {
        //user confirms deletion
        console.log("ok");
    });
}

/**
 * Template for no data
 */
function printNoResults() {
    let template = Handlebars.compile($("#no-results-template").html());
    $('.content_wrapper').html(template());
}

/**
 * Template for data
 * @param data
 * @param templateElement
 */
function generateHtml(data, templateElement) {
    let template = Handlebars.compile(templateElement.html());
    Handlebars.registerHelper('processAmount', function (options) {
        let amount = parseFloat(options.fn(this));
        return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    });
    Handlebars.registerHelper('ifCond', function (value, options) {
        if (value === 'confirmed') {
            return options.fn(this);
        }
        return options.inverse(this);
    });
    $('.content_wrapper').html(template(data));
}


