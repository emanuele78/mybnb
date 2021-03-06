import flatpickr from "flatpickr";
import CHECK_AVAILABILITY_MODULE from "./check_availability_mod";
import { Italian } from "flatpickr/dist/l10n/it.js"

/**
 * Flatpicker initialization
 */
flatpickr('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
    "locale": Italian,
    onChange: function () {
        check();
    }
});

/**
 * For edit scenario
 */
(function () {
    //check availability of a pending booking
    if($('#check_in').val() != '' && $('#check_out').val() != ''){
        check();
    }
})();

/**
 * function that responds to event associate to upgrade checkboxes and flatpicker date.
 * Send ajax request to get availability for selected dates through module
 */
function check() {
    let checkIn = $('#check_in');
    let checkOut = $('#check_out');
    $('.loading_block').show();
    $('#result').text();
    CHECK_AVAILABILITY_MODULE.check(checkIn.val(), checkOut.val(), $('#availability_result').data().apartment, function (result, days) {
        checkIn.removeClass('is-invalid');
        checkOut.removeClass('is-invalid');
        let message;
        let classColor;
        let valid = false;
        switch (result) {
            case 'INVALID_CHECK_IN':
                checkIn.addClass('is-invalid');
                break;
            case 'INVALID_CHECK_OUT':
                checkOut.addClass('is-invalid');
                break;
            case 'SERVER_ERROR':
                classColor = "error";
                message = "dato non disponibile";
                break;
            case 'AVAILABLE':
                classColor = "available";
                message = "disponibile";
                valid = true;
                break;
            case 'NOT_AVAILABLE':
                classColor = "not_available";
                message = "non disponibile";
                break;
        }
        $('#availability_result').removeClass().addClass(classColor);
        $('.loading_block').hide();
        $('#result').text(message);
        calc(days, valid);
        if (valid) {
            $('#proceed_to_booking').removeClass('btn-secondary btn-success').addClass('btn-success')
        } else {
            $('#proceed_to_booking').removeClass('btn-secondary btn-success').addClass('btn-secondary')
        }
    }, true, $('meta[name="csrf-token"]').attr('content'));
}

/**
 * Calc the amount for selected dates
 * @param days
 * @param valid
 */
function calc(days, valid) {
    let day_count = $('#day_count');
    let apartment_amount = $('#apartment_amount');
    let services_amount = $('#services_amount');
    let final_amount = $('#final_amount');
    day_count.text('');
    apartment_amount.text('');
    services_amount.text('');
    final_amount.text('');
    let base_price;
    if (valid) {
        day_count.text(days);
        if ($('.apartment_sale_price').length) {
            base_price = $('.apartment_sale_price').data('apartment_sale_price');
        } else {
            base_price = $('.apartment_price').data('apartment_price');
        }
        apartment_amount.text(representAmount(base_price * days));
        let checked_services_amount = 0;
        $('.upgrade_service').each(function () {
            if ($(this).is(':checked')) {
                checked_services_amount += $(this).data('service_price');
            }
        });
        services_amount.text(representAmount(checked_services_amount * days));
        final_amount.text(representAmount((checked_services_amount + base_price) * days));
    }
}

/**
 * Show the amount to the user
 * @param amount
 * @returns {string}
 */
function representAmount(amount) {
    return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

/**
 * Listener for upgrade service checboxes
 */
$('.upgrade_service').change(function () {
    check();
});