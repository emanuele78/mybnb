require('./bootstrap');
/**
 * Declaring differents endpoint for development and production
 */
const LOCAL_PORT = 8000;
const LOCAL_BASE_URI = 'http://127.0.0.1:';
const PROJECT_CONSTANTS = {
    citiesEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/cities',
    tokenEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/tokens',
    activationTokenEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/tokens',
    apartmentAvailabilityEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments/{apartment}/booking',
    authApartmentAvailabilityEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/auth/apartments/{apartment}/booking',
    mapEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments/{apartment}/map',
    addressEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments/{apartment}/address',
    paymentTokenEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/payments/token',
    bookingPaymentEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/booking/payment',
    messagesEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments/{apartment}/messages',
    messagesDashboardEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/messages',
    threadEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments/threads/{thread}',
    bookingListEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/bookings',
    apartmentsEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments',
    apartmentEndpoint: LOCAL_BASE_URI + LOCAL_PORT + '/api/apartments/{apartment}',
};
const PRODUCTION_BASE_URI = 'https://emanuelemazzante.dev/portfolio/mybnb';
if (process.env.NODE_ENV === 'production') {
    PROJECT_CONSTANTS.citiesEndpoint = PRODUCTION_BASE_URI + '/api/cities';
    PROJECT_CONSTANTS.tokenEndpoint = PRODUCTION_BASE_URI + '/api/tokens';
    PROJECT_CONSTANTS.activationTokenEndpoint = PRODUCTION_BASE_URI + '/tokens';
    PROJECT_CONSTANTS.apartmentAvailabilityEndpoint = PRODUCTION_BASE_URI + '/api/apartments/{apartment}/booking';
    PROJECT_CONSTANTS.authApartmentAvailabilityEndpoint = PRODUCTION_BASE_URI + '/api/auth/apartments/{apartment}/booking';
    PROJECT_CONSTANTS.mapEndpoint = PRODUCTION_BASE_URI + '/api/apartments/{apartment}/map';
    PROJECT_CONSTANTS.addressEndpoint = PRODUCTION_BASE_URI + '/api/apartments/{apartment}/address';
    PROJECT_CONSTANTS.paymentTokenEndpoint = PRODUCTION_BASE_URI + '/api/payments/token';
    PROJECT_CONSTANTS.bookingPaymentEndpoint = PRODUCTION_BASE_URI + '/api/booking/payment';
    PROJECT_CONSTANTS.messagesEndpoint = PRODUCTION_BASE_URI + '/api/apartments/{apartment}/messages';
    PROJECT_CONSTANTS.messagesDashboardEndpoint = PRODUCTION_BASE_URI + '/api/messages';
    PROJECT_CONSTANTS.threadEndpoint = PRODUCTION_BASE_URI + '/api/apartments/threads/{thread}';
    PROJECT_CONSTANTS.bookingListEndpoint = PRODUCTION_BASE_URI + '/api/bookings';
    PROJECT_CONSTANTS.apartmentsEndpoint = PRODUCTION_BASE_URI + '/api/apartments';
    PROJECT_CONSTANTS.apartmentEndpoint = PRODUCTION_BASE_URI + '/api/apartments/{apartment}';
}
export default PROJECT_CONSTANTS;
