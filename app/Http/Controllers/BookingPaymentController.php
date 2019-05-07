<?php
	
	namespace App\Http\Controllers;
	
	use App\Booking;
	use App\Services\BraintreeGateway;
	use Auth;
	use Barryvdh\DomPDF\Facade as PDF;
	use Illuminate\Http\Request;
	use Validator;
	
	class BookingPaymentController extends Controller {
		
		/**
		 * Save the payment for a booking if not expired
		 *
		 * @param Request $request
		 * @param BraintreeGateway $braintreeGateway
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function store(Request $request, BraintreeGateway $braintreeGateway) {
			
			$validator = Validator::make(
			  $request->all(), [
			  'booking_reference' => 'required|exists:bookings,reference',
			  'paymentMethodNonce' => 'required'
			]);
			if ($validator->fails()) {
				return response()->json(['success' => false, 'message' => 'invalid_data'], 500);
			}
			if (Booking::isExpired($validator->validated()['booking_reference'], config('project.pending_booking_max_life'))) {
				return response()->json(['success' => false, 'message' => 'expired'], 500);
			}
			$reference = $validator->validated()['booking_reference'];
			$nonce = $validator->validated()['paymentMethodNonce'];
			$booking = Booking::findByReference($reference);
			$result = $braintreeGateway->performPayment($booking->bookingAmount(), $nonce);
			if ($result) {
				$booking->confirm();
				return response()->json(['success' => true], 200);
			}
			return response()->json(['success' => false, 'message' => 'braintree_error'], 500);
		}
		
		/**
		 * Return the pdf receipt for the given booking
		 *
		 * @param Booking $booking
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function show(Booking $booking) {
			
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			if (Auth::user()->id != $booking->user_booking_id) {
				return abort(403);
			}
			$pdf = PDF::loadView('pdf.receipt', $booking->dataForInvoice());
			return $pdf->stream('invoice.pdf');
		}
	}
