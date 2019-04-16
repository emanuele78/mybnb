require('./bootstrap');
/**
 * Declaring differents endpoint for development and production
 */
const LOCAL_PORT = 8000;
const PROJECT_CONSTANTS = {
    citiesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/cities',
    tokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/tokens',
    activationTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/tokens',
    apartmentAvailabilityEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/',
    messagesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/messages'
};

if (process.env.NODE_ENV === 'production') {
    PROJECT_CONSTANTS.citiesEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/cities';
    PROJECT_CONSTANTS.tokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/tokens';
    PROJECT_CONSTANTS.activationTokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/tokens';
    PROJECT_CONSTANTS.apartmentAvailabilityEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/apartments/';
    PROJECT_CONSTANTS.messagesEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/messages';
}
export default PROJECT_CONSTANTS;