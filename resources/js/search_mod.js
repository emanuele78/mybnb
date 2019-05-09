import PROJECT_MODULE from "./app";

/**
 * Exported object
 *
 * @type {{}}
 */
const HANDLE_SEARCH_REQUEST = {
    total_results: 0,
    request_data: null,
    current_page: 1,
    more_results: false,
    sendRequest: function (data, callback) {
        const outer = this;
        //starting search with new parameters
        this.request_data = data;
        this.current_page = 1;
        performRequest(this.current_page, data, function (response) {
            outer.total_results = response.total;
            outer.more_results = response.current_page < response.last_page;
            callback(response.data);
        });
    },
    loadMore: function (callback) {
        const outer = this;
        performRequest(++this.current_page, this.request_data, function (response) {
            outer.total_results = response.total;
            outer.current_page = response.current_page;
            outer.more_results = response.current_page < response.last_page;
            callback(response.data);
        });
    }
};

/**
 * Send request to server
 */
function performRequest(page, data, callback) {
    $.ajax(PROJECT_MODULE.apartmentSearchEndpoint + '?page=' + page, {
        success: function (response) {
            callback(response);
        },
        error: function (e) {
            console.log(e);
        },
        data: data
    });
}

/**
 * Exporting the object
 */
export default HANDLE_SEARCH_REQUEST;