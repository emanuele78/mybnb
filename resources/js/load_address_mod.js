import PROJECT_MODULE from "./app";

/**
 * Exported object
 *
 * @type {{getAddress: HANDLE_ADDRESS.getAddress}}
 */
const HANDLE_ADDRESS = {

    getAddress: function (apartment, callback) {
        performRequest(apartment, callback);
    }
};

/**
 * Perform the request to get the address for the apartment
 * @param apartment
 * @param callback
 */
function performRequest(apartment, callback) {
    const URL = PROJECT_MODULE.addressEndpoint.replace('{apartment}', apartment);
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

export default HANDLE_ADDRESS;
