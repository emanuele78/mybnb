import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'
import MODAL_ACTION_MODULE from "./modal_action_mod";

/**
 * Entry point
 */
sendRequest();
registerListenerForVisualizationDropdown();

/**
 * Send request to get data for own apartments | other apartments threads
 */
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
            if ($('.dropdown-item.active').data('type') === 'my_apartments') {
                $('.main_message_title').text('Messaggi per i tuoi appartamenti')
            } else {
                $('.main_message_title').text('Messaggi per altri appartamenti')
            }
            attachDeleteButtonsListeners();
        }
    });
}

/**
 * Listener for dropdown
 */
function registerListenerForVisualizationDropdown() {
    $('.dropdown-item').click(function (e) {
        e.preventDefault();
        $('.dropdown-item').removeClass('active');
        $(this).addClass('active');
        sendRequest();
    });
}

/**
 * Listener for accordion toggling
 */
function registerListenerForAccordion() {
    $('.toggle_text').off();
    $('.toggle_text').click(function () {
        $(this).text($(this).text() === 'Mostra conversazioni' ? 'Nascondi conversazioni' : 'Mostra conversazioni');
    });
}

/**
 * Print the data received by the server
 * @param data
 */
function printResults(data) {
    if ($('.dropdown-item.active').data('type') === 'my_apartments') {
        generateHtmlForOwnApartments(data);
        registerListenerForAccordion();
    } else {
        generateHtmlForOtherApartments(data);
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
 * Template for data - other apartments
 * @param data
 */
function generateHtmlForOtherApartments(data) {
    let template = Handlebars.compile($("#other-apartments-template").html());
    Handlebars.registerHelper('processImage', function (options) {
        return options.fn(this);
    });
    $('.content_wrapper').html(template(data));
}

/**
 * Template for data - own apartments
 * @param data
 */
function generateHtmlForOwnApartments(data) {
    let template = Handlebars.compile($("#own-apartments-template").html());
    $('.content_wrapper').html(template(data));
}

/**
 * Attach listeners for delete buttons in
 */
function attachDeleteButtonsListeners() {

    $('.delete_other_apartments_thread').off().click(function () {
        let itemToBeRemoved = $(this);
        let threadId = $(this).attr('data-thread');
        MODAL_ACTION_MODULE.showActionModal(null, null, function () {
            deleteThread(threadId, function () {
                //remove the elementdata
                $(itemToBeRemoved).parents('.single_apartment').remove();
            })
        });
    });
    $('.delete_my_apartments_thread').off().click(function () {
        let threadId = $(this).attr('data-thread');
        MODAL_ACTION_MODULE.showActionModal(null, null, function () {
            deleteThread(threadId, function () {
                //remove the element inside the accordion
                $('#thread_section_' + threadId).remove();
                //check for apartments without threads
                removeApartmentWithoutThreads();
            });
        });
    });
}

/**
 * Send request to delete the selected thread
 */
function deleteThread(thread, successCallback) {
    let url = PROJECT_MODULE.threadEndpoint.replace('{thread}', thread);
    $.ajax(url, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            successCallback();
        },
        error: function (e) {
            console.log(e);
        }
    });
}

/**
 * Remove apartment cards without threads
 */
function removeApartmentWithoutThreads() {
    $('.single_apartment').each(function () {
        if ($(this).find('.apartment_threads_section').children().length === 0) {
            $(this).remove();
        }
    })
}
