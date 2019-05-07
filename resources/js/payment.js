import PROJECT_MODULE from "./app";
import PAYMENT_MODULE from "./payment_mod";

/**
 * Handle the payment
 */
(function () {
    const PAYLOAD = {
        'booking_reference': $('#booking_ref').data('reference')
    };
    const CSRF = $('meta[name="csrf-token"]').attr('content');
    PAYMENT_MODULE.initialize(CSRF, PROJECT_MODULE.bookingPaymentEndpoint, PAYLOAD);
})();