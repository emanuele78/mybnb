<?php
	
	namespace App\Traits;
	
	use App\Apartment;
	use App\Booking;
	use App\ReservedDay;
	use Auth;
	use Carbon\Carbon;
	
	trait AvailabilityTrait {
		
		/**
		 * Check if the given interval is available for the passed apartment
		 *
		 * @param Carbon $check_in
		 * @param Carbon $check_out
		 * @param Apartment $apartment
		 * @return bool
		 */
		public function isPeriodAvailable(Carbon $check_in, Carbon $check_out, Apartment $apartment): bool {
			
			$check_in->setTime(0, 0, 0);
			$check_out->setTime(0, 0, 0);
			//check for reserved days set by the host
			$reserved_days = ReservedDay::forApartment($apartment->id);
			foreach ($reserved_days as $reserved_day) {
				if ($reserved_day->day->isBetween($check_in, $check_out, true)) {
					return false;
				}
			}
			//reserved days check passed
			//check for other bookings
			$bookings = Booking::forApartment($apartment->id);
			$max_life_pending_booking = config('project.pending_booking_max_life');
			foreach ($bookings as $booking) {
				if ($check_in->greaterThan($booking->check_in) && $check_out->lessThan($booking->check_out)) {
					//need to check if overlapped bookig is confirmed or pending within max_life_pending_booking
					if ($this->isBookingConfirmedOrPendingNotExpired($booking, $max_life_pending_booking)) {
						return false;
					}
				} elseif (($check_in->greaterThan($booking->check_in) && $check_in->lessThan($booking->check_out)) || ($check_out->greaterThan($booking->check_in) && $check_out->lessThan($booking->check_out))) {
					//need to check if overlapped bookig is confirmed or pending within max_life_pending_booking
					if ($this->isBookingConfirmedOrPendingNotExpired($booking, $max_life_pending_booking)) {
						return false;
					}
				} elseif ($check_in->equalTo($booking->check_in) || $check_out->equalTo($booking->check_out)) {
					//need to check if overlapped bookig is confirmed or pending within max_life_pending_booking
					if ($this->isBookingConfirmedOrPendingNotExpired($booking, $max_life_pending_booking)) {
						return false;
					}
				} elseif ($booking->check_in->greaterThan($check_in) && $booking->check_out->lessThan($check_out)) {
					//need to check if overlapped bookig is confirmed or pending within max_life_pending_booking
					if ($this->isBookingConfirmedOrPendingNotExpired($booking, $max_life_pending_booking)) {
						return false;
					}
				}
			}
			//other bookings check passed
			//check for max stay
			if ($check_out->diffInDays($check_in) > $apartment->max_stay) {
				return false;
			}
			return true;
		}
		
		/**
		 * Check if a booking is confirmed or if the pending status is not yet expired
		 *
		 * @param $booking
		 * @param $max_life_pending_booking
		 * @return bool
		 */
		private function isBookingConfirmedOrPendingNotExpired($booking, $max_life_pending_booking): bool {
			
			//booking is confirmed
			if ($booking->status == 'confirmed') {
				return true;
			}
			//for a gust user, booking in pending state could be expired or not expired
			if (Auth::user() == null) {
				return (Carbon::now()->diffInMinutes($booking->created_at)) <= $max_life_pending_booking;
			}
			//authenticated user can be the same user who has the same booking in pending state
			if (Auth::user()->id == $booking->user_id) {
				//current user has current booking in pending state
				return false;
			}
			return (Carbon::now()->diffInMinutes($booking->created_at)) <= $max_life_pending_booking;
		}
	}