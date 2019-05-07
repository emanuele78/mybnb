import PROJECT_MODULE from './app.js';
import flatpickr from "flatpickr";
import Handlebars from 'handlebars/dist/cjs/handlebars'
import PAYMENT_MODULE from "./payment_mod";

const MOMENT = require('moment');

/**
 * Entry point
 */
(function () {
    //Flatpicker initialization
    flatpickr('.flatpicker', {
        clickOpens: true,
        enableTime: true,
        dateFormat: "d-m-Y H:i",
        onChange: function () {
            $('.flatpickr-input').removeClass('is-invalid');
        }
    });
    //listener for promo card choice
    $('.promo_type_card').click(function () {
        $('.promo_type_card').removeClass('active');
        $(this).addClass('active');
        loadDaysForSelectedPromo($(this).data('max_length'));
        calcPrice();
    });
    //listener for day select
    $('.promo_length').change(function () {
        calcPrice();
    });
    //Listener for proceed button
    $('.button_proceed').click(function () {
        if ($('input[type="radio"]:checked').val() === 'start_date') {
            let userDate = $('.flatpickr-input').val();
            if (userDate && validDate(userDate)) {
                checkIfOverlapped(userDate, $('.promo_type_card.active').data('card_type'), $('.promo_length option:selected').val());
            } else {
                $('.flatpickr-input').removeClass('is-invalid').addClass('is-invalid');
                $('.start_promo_input').text('data non valida');
            }
        } else {
            checkIfOverlapped(null, $('.promo_type_card.active').data('card_type'), $('.promo_length option:selected').val());
        }
    });
    //listener for back button
    $('.back_button').click(function () {
        toggleView();
    });
    //load day for active promo and calc price
    loadDaysForSelectedPromo($('.promo_type_card').data('max_length'));
    calcPrice();
})();

/**
 * Calc the total amout for the select value
 */
function calcPrice() {
    let days = $('.promo_length option:selected').val();
    let pricePerDay = $('.promo_type_card.active .promo_price').data('price');
    let amount = (days * pricePerDay).toLocaleString('it-IT', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    $('.amount').text(amount);
}

/**
 * Check if user date is a future date
 * @param userDate
 * @returns {boolean}
 */
function validDate(userDate) {
    let momentDate = MOMENT(userDate, 'DD-MM-YYYY H:i');
    return momentDate.isSameOrAfter(MOMENT(), 'minute');
}

/**
 * Populate select with days count
 * @param day_count
 */
function loadDaysForSelectedPromo(day_count) {
    let data = [];
    for (let i = 1; i <= day_count; i++) {
        data.push(i);
    }
    let template = Handlebars.compile($("#length-template").html());
    $('.promo_length').html(template(data));
}

/**
 * Send request to check if the choose promo overlaps another promo
 * @param startDate
 * @param cardType
 * @param dayLength
 */
function checkIfOverlapped(startDate, cardType, dayLength) {
    let url = PROJECT_MODULE.promotionEndpoint.replace('{apartment}', $('.apartment_title').data('apartment'));
    $.ajax(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'card_type': cardType,
            'start_at': startDate,
            'day_length': dayLength,
        },
        success: function (data) {
            evaluateResponse(data.overlaps, startDate, cardType, dayLength);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

/**
 * Show/hide promotion detail/payment form
 */
function toggleView() {
    $('.promo_detail').toggle();
    $('.payment_module').toggle();
}

/**
 * If promotion not overlaps, proceed with payment
 * @param overlaps
 * @param startDate
 * @param cardType
 * @param dayLength
 */
function evaluateResponse(overlaps, startDate, cardType, dayLength) {
    if (overlaps) {
        $('.flatpickr-input').removeClass('is-invalid').addClass('is-invalid');
        $('.start_promo_input').text('La data è sovrapposta con quella di un\'altra promozione');
        return;
    }
    toggleView();
    const PAYLOAD = {
        'card_type': cardType,
        'day_length': dayLength,
        'start_at': startDate
    };
    const CSRF = $('meta[name="csrf-token"]').attr('content');
    const ENDPOINT = PROJECT_MODULE.promotionPaymentEndpoint.replace('{apartment}', $('.apartment_title').data('apartment'));
    PAYMENT_MODULE.initialize(CSRF, ENDPOINT, PAYLOAD);
}

