import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'

sendRequest();
registerListenerForVisualizationDropdown();

function sendRequest() {
    let url = PROJECT_MODULE.messagesDashboardEndpoint;
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
            if ($('.dropdown-item.active').data('type') === 'my_apartment') {
                $('.main_message_title').text('Messaggi per i tuoi appartamenti')
            } else {
                $('.main_message_title').text('Messaggi per altri appartamenti')
            }
        }
    });
}

function registerListenerForVisualizationDropdown() {
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

function printResults(data) {
    if ($('.dropdown-item.active').data('type') === 'my_apartment') {
        generateHtml(data, $("#own-apartments-template"));
        registerListenerForAccordion();
    } else {
        generateHtml(data, $("#other-apartments-template"));
    }
}

function printNoResults() {
    let template = Handlebars.compile($("#no-results-template").html());
    $('.content_wrapper').html(template());
}

function generateHtml(data, templateElement) {
    let template = Handlebars.compile(templateElement.html());
    $('.content_wrapper').html(template(data));
}