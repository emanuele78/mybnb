import PROJECT_MODULE from "./app";

const HANDLE_MAP = {

    getMap: function (apartment, callback) {
        performRequest(apartment, callback);
    }
};

function performRequest(apartment, callback) {
    const URL = PROJECT_MODULE.mapEndpoint.replace('{apartment}', apartment);
    $.ajax(URL, {
        method: 'GET',
        success: function (data) {
            callback({
                'success': true,
                'data': data
            });
        },
        error: function () {
            callback({
                'success': false
            });
        }
    });
}

export default HANDLE_MAP;
