import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'
import MODAL_INFO_MODULE from "./modal_info_mod";

/**
 * Entry point
 */
sendRequest();
registerListenerForDropdowns();

/**
 * Send request to get data for own bookings | other apartments bookings
 */
function sendRequest() {
    let url = PROJECT_MODULE.apartmentsEndpoint;
    $.ajax(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'show': $('.dropdown_show.active').data('show'),
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
 * Print the data received by the server
 * @param data
 */
function printResults(data) {
    let template = Handlebars.compile($("#apartment-template").html());
    Handlebars.registerHelper('processAmount', function (options) {
        let amount = parseFloat(options.fn(this));
        return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    });
    $('.content_wrapper').html(template(data));
    registerListenerForInPageActions();
}

/**
 * Template for no data
 */
function printNoResults() {
    let template = Handlebars.compile($("#no-results-template").html());
    $('.content_wrapper').html(template());
}

/**
 * Register listener for delete and show/hide apartment buttons
 */
function registerListenerForInPageActions() {
    $('.show_apartment').off().click(function () {
        let currentApartment = $(this).data('apartment');
        $('.waiting.' + currentApartment).show();
        performAction(currentApartment, 'set_visible', function (success) {

        });
    });
    $('.hide_apartment').off().click(function () {
        let currentApartment = $(this).data('apartment');
        $('.waiting.' + currentApartment).show();
        performAction(currentApartment, 'set_hidden', function (success) {

        });
    });
}

function performAction(apartment, action, callback) {
    let url = PROJECT_MODULE.apartmentEndpoint.replace('{apartment}', apartment);
    let success = true;
    $.ajax(url, {
        method: 'PATCH',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'action': action,
        },
        success: function (data) {
            console.log(data);
        },
        error: function (e) {
            success = false;
            console.log(e);
        },
        complete: function () {
            sendRequest();
        }
    });
}

function removeCard(apartment) {
    $('.apartment-card-' + apartment).remove();
}

// /**
//  * Listener for accordion toggling
//  */
// function registerListenersForAccordion() {
//     $('.expand_booking_list').off();
//     $('.expand_booking_list').click(function () {
//         $(this).text($(this).text() === 'Mostra elenco prenotazioni' ? 'Nascondi elenco prenotazioni' : 'Mostra elenco prenotazioni');
//     });
//     $('.expand_calendar').off();
//     $('.expand_calendar').click(function () {
//         $(this).text($(this).text() === 'Mostra calendario prenotazioni' ? 'Nascondi calendario prenotazioni' : 'Mostra calendario prenotazioni');
//     });
// }

// /**
//  * Show info of the given booking in a modal view
//  * @param apartmentsWithBookings
//  * @param reference
//  */
// function showBookingInfo(apartmentsWithBookings, reference) {
//     console.log(apartmentsWithBookings);
//     for (let apartmentWithBookings of apartmentsWithBookings) {
//         for (let booking of apartmentWithBookings.bookings) {
//             if (booking.booking_reference === reference) {
//                 showModal(booking);
//                 return;
//             }
//         }
//     }
// }
//
// /**
//  * Show the given booking on a modal view
//  * @param booking
//  */
// function showModal(booking) {
//     console.log(booking);
//     let template = Handlebars.compile($("#info-booking-template").html());
//     Handlebars.registerHelper('processAmount', function (options) {
//         let amount = parseFloat(options.fn(this));
//         return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
//     });
//     $('#info_booking_content').html(template(booking));
//     MODAL_INFO_MODULE.showInfoModal(function () {
//         //user confirms deletion
//         console.log("ok");
//     });
// }



