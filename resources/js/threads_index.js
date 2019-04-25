import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'

sendRequest();

function sendRequest() {
    let url = PROJECT_MODULE.messagesEndpoint;
    $.ajax(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'show_by': $('.dropdown-item.active').data('type')
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
            registerListenerForVisualizationMode();
        }
    });
}

function registerListenerForVisualizationMode() {
    $('.dropdown-item').click(function (e) {
        e.preventDefault();
        $('.dropdown-item').removeClass('active');
        $(this).addClass('active');
        sendRequest();
    });
}

function registerListenerForAccordion() {
    $('.toggle_text').off();
    $('.toggle_text').click(function () {
        $(this).text($(this).text() === 'Mostra conversazioni' ? 'Nascondi conversazioni' : 'Mostra conversazioni');
    });
}

function printResults(results) {
    if ($('.dropdown-item.active').data('type') === 'my_apartment') {
        printResultsForOwnApartments(results);
    } else {
        printResultsForOtherApartments(results);
    }
}

function printResultsForOwnApartments(results) {
    let template = Handlebars.compile($("#apartments-template").html());
    Handlebars.registerHelper('process_image', function (ctx) {
        return '/' + ctx.fn(this);
    });
    $('.content_wrapper').html(template(results));
    registerListenerForAccordion();
}

function printResultsForOtherApartments(results) {
    console.log(results);
    let template = Handlebars.compile($("#other-apartments-template").html());
    Handlebars.registerHelper('process_image', function (ctx) {
        return '/' + ctx.fn(this);
    });
    $('.content_wrapper').html(template(results));
    registerListenerForAccordion();
}

function printNoResults() {
    let template = Handlebars.compile($("#no-results-template").html());
    $('.content_wrapper').html(template());
}
