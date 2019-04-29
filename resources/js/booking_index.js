import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'

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
                $('.main_message_title').text('Prenotazioni effettuate ai tuoi appartamenti')
            } else if ($('.dropdown_show.active').data('show') === 'other_apartments_bookings') {
                $('.main_message_title').text('Prenotazioni effettuate ad altri appartamenti')
            } else {
                $('.main_message_title').text('Prenotazioni effettuate ad altri appartamenti (in sospeso)')
            }
            // attachDeleteButtonsListeners();
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
function registerListenerForAccordion() {
    $('.expand_bookings').off();
    $('.expand_bookings').click(function () {
        $(this).text($(this).text() === 'Mostra conversazioni' ? 'Nascondi conversazioni' : 'Mostra conversazioni');
    });
}

/**
 * Print the data received by the server
 * @param data
 */
function printResults(data) {
    if ($('.dropdown_show.active').data('show') === 'my_apartments_bookings') {
        generateHtml(data, $("#own-apartments-template"));
        registerListenerForAccordion();
    } else {
        generateHtml(data, $("#other-apartments-template"));
        registerListenerForAccordion();
    }
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


