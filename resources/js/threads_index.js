import PROJECT_MODULE from './app.js';
import Handlebars from 'handlebars/dist/cjs/handlebars'

(function () {
    let url = PROJECT_MODULE.messagesEndpoint;
    $.ajax(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'show_by':$('.dropdown-item.active').data('type')
        },
        success: function (data) {
            console.log(data);
        },
        error: function (e) {
            console.log(e);
        }
    });
})();