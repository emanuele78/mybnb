<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Booking;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class BookingController extends Controller {
		
		/**
		 * Return list of bookings depending on user selection type
		 *
		 *
		 */
		public function index() {
			
			$validated = request()->validate(
			  [
				'show_by' => ['required', Rule::in(['my_apartments_bookings', 'other_apartments_bookings', 'other_apartments_bookings_pending'])],
				'filter' => ['required', Rule::in(['only_future_bookings', 'all_bookings'])]
			  ]
			);
			$user = Auth::user();
			if ($validated['show_by'] == 'my_apartments_bookings') {
				return Booking::forUserApartments($user->id, $validated['filter'] == 'only_future_bookings');
			}
			if ($validated['show_by'] == 'other_apartments_bookings') {
				return Booking::forOtherApartments($user->id, $validated['filter'] == 'only_future_bookings', false);
			}
			return Booking::forOtherApartments($user->id, $validated['filter'] == 'only_future_booking', true);
		}
	}
