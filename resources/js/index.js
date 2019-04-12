import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars';
import flatpickr from "flatpickr";

flatpickr('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
});

/**
 * Calls endpoint for get cities list in order to fill the datalist in the search bar
 */
(function () {
    $.ajax(PROJECT_MODULE.citiesEndpoint, {
        method: 'GET',
        success: function (data) {
            populateDatalist(data);
        },
        error: function () {
            console.log('Unable to load cities');
        }
    });

    function populateDatalist(data) {
        let template = $('#cities_list_template').html();
        let compiled = Handlebars.compile(template);
        $('#cities_list').html(compiled(data));
    }
})();