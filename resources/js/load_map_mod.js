import PROJECT_MODULE from "./app";

/**
 * Exported object
 *
 * @type {{getMap: HANDLE_MAP.getMap}}
 */
const HANDLE_MAP = {

    getMap: function (apartment, callback) {
        performRequest(apartment, callback);
    }
};

/**
 * Perform the request to get the apartment map
 *
 * @param apartment
 * @param callback
 */
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
