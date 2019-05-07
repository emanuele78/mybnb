import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'
import MODAL_ACTION_MODULE from "./modal_action_mod";

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
            'order': $('.dropdown_order.active').data('order'),
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
    $('.dropdown_order').click(function (e) {
        e.preventDefault();
        $('.dropdown_order').removeClass('active');
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
    //show apartment button
    $('.show_apartment').off().click(function () {
        let currentApartment = $(this).data('apartment');
        $('.waiting.' + currentApartment).show();
        changeApartmentVisibility(currentApartment, true, function () {
            //reload
            sendRequest();
        });
    });
    //hide apartment button
    $('.hide_apartment').off().click(function () {
        let currentApartment = $(this).data('apartment');
        $('.waiting.' + currentApartment).show();
        changeApartmentVisibility(currentApartment, false, function () {
            //reload
            sendRequest();
        });
    });
    //delete apartment button
    $('.delete_apartment').off().click(function () {
        let currentApartment = $(this).data('apartment');
        MODAL_ACTION_MODULE.showActionModal(null, null, function () {
            //user confirms deletion
            deleteApartment(currentApartment, function () {
                //reload
                sendRequest();
            })
        }, null);
    });
    //edit apartment button
    $('.edit_apartment').off().click(function () {
        window.location.href = $(this).data('ref').replace('apartment', $(this).data('apartment'));
    });
    //promote apartment button
    $('.promote_apartment').off().click(function () {
        window.location.href = $(this).data('ref').replace('apartment', $(this).data('apartment'));
    });
}

/**
 * Change the visibility of the given apartment
 * @param apartment
 * @param set_visible
 * @param callback
 */
function changeApartmentVisibility(apartment, set_visible, callback) {
    let url = PROJECT_MODULE.apartmentVisibilityEndpoint.replace('{apartment}', apartment);
    $.ajax(url, {
        method: 'PATCH',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'is_showed': set_visible ? 1 : 0,
        },
        error: function (e) {
            console.log(e);
        },
        complete: function () {
            callback();
        }
    });
}

/**
 * Send request to delete given apartment
 * @param apartment
 * @param callback
 */
function deleteApartment(apartment, callback) {
    let url = PROJECT_MODULE.apartmentsEndpoint + '/' + apartment;
    $.ajax(url, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            callback();
        },
        error: function (e) {
            console.log(e);
        }
    });
}



