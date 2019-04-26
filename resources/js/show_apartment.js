import MAP_MODULE from "./load_map_mod";
import ADDRESS_MODULE from "./load_address_mod";
import MESSAGE_MODULE from "./send_message_mod";

/**
 * Load map and address for the apartment async
 */
(function () {
    const APARTMENT_SLUG = $('#tomtom_map').data().apartment;

    MAP_MODULE.getMap(APARTMENT_SLUG, function (response) {
        if (response.success) {
            $('.loading_map').hide();
            $('#marker').show();
            $('#tomtom_map').attr('src', "data:image/png;charset=binary;base64," + response.data);
        } else {
            $('.loading_map').html('N/D');
        }
    });

    ADDRESS_MODULE.getAddress(APARTMENT_SLUG, function (response) {
        if (response.success) {
            $('#apartment_address').text(formatAddress(response.data));
        } else {
            $('#apartment_address').text('Indirizzo non disponibile');
        }
    });

    function formatAddress(data) {
        let formatted_address = [];

        if (!isEmpty(data.streetName)) {
            formatted_address.push(data.streetName);
        }

        if (!isEmpty(data.municipality)) {
            formatted_address.push(data.municipality);
        }

        if (!isEmpty(data.postal_code)) {
            formatted_address.push('(' + data.postal_code + ')');
        }

        if (!isEmpty(data.province)) {
            formatted_address.push(data.province);
        }

        return formatted_address.join(', ');
    }

    function isEmpty(value) {
        return (!value || value.length === 0);
    }
})();

/**
 * Listener for sending message button
 */
$('#submit_message').click(function (e) {
    e.preventDefault();
    let textArea = $('#body');
    if (textArea.val().length < 10) {
        textArea.addClass('is-invalid');
        return;
    }
    textArea.removeClass('is-invalid');
    let apartment = $("#message_apartment_slug").val();
    $(this).attr('disabled', 'disabled');
    MESSAGE_MODULE.sendMessageToApartment(apartment, textArea.val(), $('meta[name="csrf-token"]').attr('content'), function (response) {
        if (response.success) {
            $('#message_wrapper').removeClass('alert-danger');
            $('#message_wrapper').addClass('alert-success');
            $('#message_response').text('Messaggio inviato correttamente');
            textArea.val('');
        } else {
            $('#message_wrapper').removeClass('alert-success');
            $('#message_wrapper').addClass('alert-danger');
            $('#message_response').text('Errore durante l\'invio del messaggio');
        }
        $('#submit_message').removeAttr('disabled');
    });
});