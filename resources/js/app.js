/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const LOCAL_PORT = 8000;
const PROJECT_CONSTANTS = {
    citiesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/cities',
    tokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/tokens',
    activationTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/tokens'
};

if (process.env.NODE_ENV === 'production') {
    PROJECT_CONSTANTS.citiesEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/cities';
    PROJECT_CONSTANTS.tokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/tokens';
    PROJECT_CONSTANTS.activationTokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/tokens';
}
export default PROJECT_CONSTANTS;