import PROJECT_MODULE from "./app";

/**
 * Exported object
 * @type {{searchAddress: GEO.searchAddress, searchMap: GEO.searchMap}}
 */
const GEO = {

    searchAddress: function (searched_text, token_csrf, callback) {
        performAddressSearch(searched_text, token_csrf, callback);
    },
    searchMap: function (lat, lng, token_csrf, callback) {
        performSearchMap(lat, lng, token_csrf, callback);
    }

};

/**
 * Search all the matching address from input text
 * @param searched_text
 * @param token_csrf
 * @param callback
 */
function performAddressSearch(searched_text, token_csrf, callback) {
    const URL = PROJECT_MODULE.geoSearchAddressesEndpoint;
    $.ajax(URL, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token_csrf
        },
        data: {
            'input': searched_text,
        },
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

/**
 * Return a map from the given coordinates
 * @param lat
 * @param lng
 * @param token_csrf
 * @param callback
 */
function performSearchMap(lat, lng, token_csrf, callback) {
    const URL = PROJECT_MODULE.geoSearchMapEndpoint;
    $.ajax(URL, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token_csrf
        },
        data: {
            'lat': lat,
            'lng': lng,
        },
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

export default GEO;