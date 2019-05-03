import PROJECT_MODULE from "./app";
import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import '../../node_modules/@fullcalendar/core/main.css';
import '../../node_modules/@fullcalendar/daygrid/main.css';
import itLocale from '@fullcalendar/core/locales/it';
import interactionPlugin from '@fullcalendar/interaction';

const MOMENT = require('moment');

/**
 * fullcalendar.io instance
 */
let calendar;
/**
 * array of reserved days
 * @type {Array}
 */
let reserved_days = [];

/**
 * Exported object
 * @type {{isReserved: (function(*=): *), reserve: CALENDAR_MOD.reserve, initializeToElement: CALENDAR_MOD.initializeToElement, reservedDays: (function(): *[]), free: CALENDAR_MOD.free}}
 */
const CALENDAR_MOD = {

    initializeToElement: function (element, dayClickCallback) {
        initializeCalendar(element, dayClickCallback);
    },
    isReserved: function (id) {
        return checkIfReserved(id);
    },
    reserve: function (date) {
        reserveDay(date);
    },
    free: function (date) {
        freeDay(date);
    },
    reservedDays: function () {
        return reserved_days.slice(0);
    }

};

/**
 * Initialize fullcalendar.io instance
 * @param element
 * @param dayClickCallback
 */
function initializeCalendar(element, dayClickCallback) {
    calendar = new Calendar(element, {
        plugins: [dayGridPlugin, interactionPlugin],
        defaultView: 'dayGridMonth',
        height: 500,
        locale: itLocale,
        dateClick: function (day) {
            dayClickCallback(day.dateStr);
        }
    });
    calendar.render();
}

/**
 * Return true if a reserved day is found, false otherwise
 * @param id - the id is the representation of a date in the format y-m-d
 * @returns {boolean}
 */
function checkIfReserved(id) {
    return calendar.getEventById(id) != null;
}

/**
 * Create an event to reserve the given day
 * @param day
 */
function reserveDay(day) {
    let momentDay = MOMENT(day, "YYYY-MM-DD");
    calendar.addEvent({
        id: day,
        title: 'Riservato',
        start: day,
        end: momentDay.add(1, 'days').format("YYYY-MM-DD")
    });
    reserved_days.push({id: day, value: MOMENT(day, "YYYY-MM-DD").format('DD-MM-YYYY')});
}

/**
 * Remove the event and set the given id/date as free
 * @param date
 */
function freeDay(date) {
    calendar.getEventById(date).remove();
    reserved_days = reserved_days.filter(function (value) {
        return value.id !== date;
    });
}

/**
 * Export
 */
export default CALENDAR_MOD;