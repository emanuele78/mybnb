import flatpickr from "flatpickr";
import CHECK_AVAILABILITY_MODULE from "./check_availability_mod";

/**
 * Initialize flatpicker
 */
flatpickr('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
});

/**
 * Listener for check availability button
 */
$('#check_availability').click(function () {
    let checkIn = $('#check_in');
    let checkOut = $('#check_out');
    $('#check_availability').attr('disabled', 'disabled');
    $('.loading_block').show();
    CHECK_AVAILABILITY_MODULE.check(checkIn.val(), checkOut.val(), $('#check_availability').data().apartment, function (result) {
        checkIn.removeClass('is-invalid');
        checkOut.removeClass('is-invalid');
        $('#check_availability').removeAttr('disabled');
        let message;
        let classColor;
        console.log(result);
        switch (result) {
            case 'INVALID_CHECK_IN':
                checkIn.addClass('is-invalid');
                break;
            case 'INVALID_CHECK_OUT':
                checkOut.addClass('is-invalid');
                break;
            case 'SERVER_ERROR':
                message = "dato non disponibile";
                classColor = "text-primary";
                break;
            case 'AVAILABLE':
                classColor = "text-success";
                message = "disponibile";
                break;
            case 'NOT_AVAILABLE':
                classColor = "text-danger";
                message = "non disponibile";
                break;
        }
        $('#result').removeClass().addClass(classColor).text(message);
        $('.loading_block').hide();
    });
});
