import flatpickr from "flatpickr";
import CHECK_AVAILABILITY_MODULE from "./check_availability_mod";

flatpickr('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
    onChange: function () {
        check();
    }
});

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
        if(valid){
            $('#proceed_to_booking').removeClass('btn-secondary btn-success').addClass('btn-success')
        }else{
            $('#proceed_to_booking').removeClass('btn-secondary btn-success').addClass('btn-secondary')
        }
    });
}

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

function representAmount(amount) {
    return amount.toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

$('.upgrade_service').change(function () {
    check();
});