import flatpickr from "flatpickr";
import {Italian} from "flatpickr/dist/l10n/it.js"

/**
 * Entry point
 */
(function () {
    //initialize flatpicker
    flatpickr('.flatpicker', {
        clickOpens: true,
        dateFormat: "d-m-Y",
        "locale": Italian
    });
})();