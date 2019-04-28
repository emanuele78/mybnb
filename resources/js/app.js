require('./bootstrap');
/**
 * Declaring differents endpoint for development and production
 */
const LOCAL_PORT = 8000;
const PROJECT_CONSTANTS = {
    citiesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/cities',
    tokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/tokens',
    activationTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/tokens',
    apartmentAvailabilityEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/booking',
    authApartmentAvailabilityEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/auth/apartments/{apartment}/booking',
    mapEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/map',
    addressEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/address',
    paymentTokenEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/payments/token',
    bookingPaymentEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/booking/payment',
    messagesEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/{apartment}/messages',
    messagesDashboardEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/messages',
    threadEndpoint: 'http://127.0.0.1:' + LOCAL_PORT + '/api/apartments/threads/{thread}',

};

if (process.env.NODE_ENV === 'production') {
    PROJECT_CONSTANTS.citiesEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/cities';
    PROJECT_CONSTANTS.tokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/tokens';
    PROJECT_CONSTANTS.activationTokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/tokens';
    PROJECT_CONSTANTS.apartmentAvailabilityEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/apartments/{apartment}/booking';
    PROJECT_CONSTANTS.authApartmentAvailabilityEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/auth/apartments/{apartment}/booking';
    PROJECT_CONSTANTS.mapEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/apartments/{apartment}/map';
    PROJECT_CONSTANTS.addressEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/apartments/{apartment}/address';
    PROJECT_CONSTANTS.paymentTokenEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/payments/token';
    PROJECT_CONSTANTS.bookingPaymentEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/booking/payment';
    PROJECT_CONSTANTS.messagesEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/apartments/{apartment}/messages';
    PROJECT_CONSTANTS.messagesDashboardEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/messages';
    PROJECT_CONSTANTS.threadEndpoint = 'https://emanuelemazzante.dev/portfolio/mybnb/api/apartments/threads/{thread}';
}
export default PROJECT_CONSTANTS;
