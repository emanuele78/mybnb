import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars';
import flatpickr from "flatpickr";

flatpickr('.flatpicker', {
    clickOpens: true,
    dateFormat: "d-m-Y",
});

(function () {
    $.ajax(PROJECT_MODULE.citiesEndpoint, {
        method: 'GET',
        success: function (data) {
            console.log(data);
            populateDatalist(data);
        },
        error: function (error) {
            console.log(error);
        }
    });

    function populateDatalist(data) {
        let template = $('#cities_list_template').html();
        let compiled = Handlebars.compile(template);
        $('#cities_list').html(compiled(data));
    }
})();