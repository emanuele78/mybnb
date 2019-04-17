import PROJECT_MODULE from "./app";

let moment = require('moment');

const HANDLE_AVAILABILITY = {

    check: function (checkIn, checkOut, apartment, callback) {
        if (!isDateValid(checkIn) || isDateBeforeToday(checkIn)) {
            callback('INVALID_CHECK_IN');
            return;
        }
        if (!isDateValid(checkOut) || !isIntervalValid(checkIn, checkOut)) {
            callback('INVALID_CHECK_OUT');
            return;
        }
        performCheck(checkIn, checkOut, apartment, callback);
    }
};

function performCheck(checkIn, checkOut, apartment, callback) {
    let result;
    const URL = PROJECT_MODULE.apartmentAvailabilityEndpoint.replace('{apartment}', apartment);
    $.ajax(URL, {
        method: 'GET',
        success: function (data) {
            if (data.available) {
                result = 'AVAILABLE';
            } else {
                result = 'NOT_AVAILABLE';
            }
        },
        error: function () {
            result = 'SERVER_ERROR';
        },
        data: {
            'check-in': checkIn,
            'check-out': checkOut,
        },
        complete: function () {
            callback(result);
        }
    });
}

function isDateValid(string_date) {
    return parseDate(string_date).isValid();
}

function isIntervalValid(string_date_before, string_date_after) {
    return parseDate(string_date_before).isBefore(parseDate(string_date_after));
}

function isDateBeforeToday(string_date) {
    return parseDate(string_date).isBefore(moment(), "day");
}

function parseDate(string_date) {
    return moment(string_date, "DD-MM-YYYY");
}

export default HANDLE_AVAILABILITY;