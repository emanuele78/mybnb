import flatpickr from "flatpickr";
import PROJECT_MODULE from "./app";

let moment = require('moment');

flatpickr('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
});

$('#check_availability').click(function () {
    let checkIn = $('#check_in');
    let checkOut = $('#check_out');

    if (!isDateValid(checkIn)) {
        checkIn.addClass('is-invalid');
        return;
    } else {
        checkIn.removeClass('is-invalid');
    }

    if (isCheckInBeforeToday(checkIn)) {
        checkIn.addClass('is-invalid');
        return;
    } else {
        checkIn.removeClass('is-invalid');
    }

    if (!isDateValid(checkOut)) {
        checkOut.addClass('is-invalid');
        return;
    } else {
        checkOut.removeClass('is-invalid');
    }

    if (!isIntervalValid(checkIn, checkOut)) {
        checkIn.addClass('is-invalid');
        checkOut.addClass('is-invalid');
        return;
    } else {
        checkIn.removeClass('is-invalid');
        checkOut.removeClass('is-invalid');
    }
    $('#loading_block').collapse('show');
    let requestButton = $('#check_availability');
    requestButton.attr('disabled', 'disabled');
    sendRequest(checkIn.val(), checkOut.val(), requestButton.data().apartment, printResult);
});

function isDateValid(inputElement) {
    return parseDate(inputElement.val()).isValid();
}

function isIntervalValid(inputElementBefore, inputElementAfter) {
    return parseDate(inputElementBefore.val()).isBefore(parseDate(inputElementAfter.val()));
}

function isCheckInBeforeToday(inputElement) {
    return parseDate(inputElement.val()).isBefore(moment(),"day");
}

function parseDate(stringDate) {
    return moment(stringDate, "DD-MM-YYYY");
}

function sendRequest(checkIn, checkOut, apartment, callback) {
    let result = null;
    $.ajax(PROJECT_MODULE.apartmentAvailabilityEndpoint + apartment + "/booking", {
        method: 'GET',
        success: function (data) {
            console.log(data);
            result = data.available;
        },
        data: {
            'check-in': checkIn,
            'check-out': checkOut,
        },
        error: function (e) {
            console.log(e);
        },
        complete: function () {
            callback(result);
        }
    });
}

function printResult(result) {
    $('#check_availability').removeAttr('disabled');
    let message;
    let classColor;
    switch (result) {
        case true:
            message = "Disponibile";
            classColor = "available";
            break;
        case false:
            message = "Non disponibile";
            classColor = "not_available";
            break;
        default:
            message = "Dato non disponibile - riprovare più tardi";
            classColor = "unknown";
    }
    $('#result').removeClass().addClass(classColor).text(message);
}
