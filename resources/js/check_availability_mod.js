import PROJECT_MODULE from "./app";

let moment = require('moment');

/**
 * Exported object
 * @type {{check: HANDLE_AVAILABILITY.check}}
 */
const HANDLE_AVAILABILITY = {

    check: function (checkIn, checkOut, apartment, callback, useAuth, csrfToken) {
        if (!isDateValid(checkIn) || isDateBeforeToday(checkIn)) {
            callback('INVALID_CHECK_IN');
            return;
        }
        if (!isDateValid(checkOut) || !isIntervalValid(checkIn, checkOut)) {
            callback('INVALID_CHECK_OUT');
            return;
        }
        performCheck(checkIn, checkOut, apartment, callback, useAuth, csrfToken);
    }
};

/**
 * Perform the ajax request
 *
 * @param checkIn
 * @param checkOut
 * @param apartment
 * @param callback
 * @param useAuth
 * @param csrfToken
 */
function performCheck(checkIn, checkOut, apartment, callback, useAuth, csrfToken) {
    console.log(checkIn);
    console.log(checkOut);
    let result;
    const DAY_COUNT = dayCount(checkIn, checkOut);
    const AJAX_OPTIONS = {
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
            callback(result, DAY_COUNT);
        }
    };
    if (useAuth) {
        AJAX_OPTIONS.headers = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        }
    }
    const URL = useAuth ? PROJECT_MODULE.authApartmentAvailabilityEndpoint.replace('{apartment}', apartment) : PROJECT_MODULE.apartmentAvailabilityEndpoint.replace('{apartment}', apartment);
    $.ajax(URL, AJAX_OPTIONS);
}

/**
 * Check for date validity
 *
 * @param string_date
 * @returns {boolean}
 */
function isDateValid(string_date) {
    return parseDate(string_date).isValid();
}

/**
 * Check for date interval validity
 *
 * @param string_date_before
 * @param string_date_after
 * @returns {boolean}
 */
function isIntervalValid(string_date_before, string_date_after) {
    return parseDate(string_date_before).isBefore(parseDate(string_date_after));
}

/**
 * Check if checkin is before checkout
 *
 * @param string_date
 * @returns {boolean}
 */
function isDateBeforeToday(string_date) {
    return parseDate(string_date).isBefore(moment(), "day");
}

/**
 * Parse the date
 *
 * @param string_date
 * @returns {moment.Moment}
 */
function parseDate(string_date) {
    return moment(string_date, "DD-MM-YYYY");
}

/**
 * Count the days between checkin and checkout
 *
 * @param check_in
 * @param check_out
 * @returns {number}
 */
function dayCount(check_in, check_out) {
    return parseDate(check_out).diff(parseDate(check_in), 'days');
}

export default HANDLE_AVAILABILITY;