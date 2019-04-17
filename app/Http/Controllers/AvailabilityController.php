<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Booking;
	use App\Http\Requests\ApartmentAvailabilityRequest;
	use App\ReservedDay;
	use Carbon\Carbon;
	
	class AvailabilityController extends Controller {
		
		public function index(Apartment $apartment, ApartmentAvailabilityRequest $request) {
			
			$check_in = Carbon::createFromFormat('d-m-Y', $request->validated()['check-in']);
			$check_in->setTime(0, 0, 0);
			$check_out = Carbon::createFromFormat('d-m-Y', $request->validated()['check-out']);
			$check_out->setTime(0, 0, 0);
			//check for reserved days set by the host
			$reserved_days = ReservedDay::where('apartment_id', $apartment->id)->get();
			foreach ($reserved_days as $reserved_day) {
				if ($reserved_day->day->isBetween($check_in, $check_out, true)) {
					return response()->json(['available' => false], 200);
				}
			}
			//reserved days check passed
			//check for booking
			$bookings = Booking::where('apartment_id', $apartment->id)->get();
			foreach ($bookings as $booking) {
				if ($check_in->greaterThan($booking->check_in) && $check_out->lessThan($booking->check_out)) {
					return response()->json(['available' => false], 200);
				} elseif (($check_in->greaterThan($booking->check_in) && $check_in->lessThan($booking->check_out)) || ($check_out->greaterThan($booking->check_in) && $check_out->lessThan($booking->check_out))) {
					return response()->json(['available' => false], 200);
				} elseif ($check_in->equalTo($booking->check_in) || $check_out->equalTo($booking->check_out)) {
					return response()->json(['available' => false], 200);
				} elseif ($booking->check_in->greaterThan($check_in) && $booking->check_out->lessThan($check_out)) {
					return response()->json(['available' => false], 200);
				}
			}
			return response()->json(['available' => true], 200);
		}
	}
