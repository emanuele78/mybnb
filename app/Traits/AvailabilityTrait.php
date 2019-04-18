<?php
	
	namespace App\Traits;
	
	use App\Apartment;
	use App\Booking;
	use App\ReservedDay;
	use Carbon\Carbon;
	
	trait AvailabilityTrait {
		
		public function isPeriodAvailable(Carbon $check_in, Carbon $check_out, Apartment $apartment): bool {
			
			//todo replace eloquent DB methods
			$check_in->setTime(0, 0, 0);
			$check_out->setTime(0, 0, 0);
			//check for reserved days set by the host
			$reserved_days = ReservedDay::where('apartment_id', $apartment->id)->get();
			foreach ($reserved_days as $reserved_day) {
				if ($reserved_day->day->isBetween($check_in, $check_out, true)) {
					return false;
				}
			}
			//reserved days check passed
			//check for other bookings
			$bookings = Booking::where('apartment_id', $apartment->id)->get();
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
		
		private function isBookingConfirmedOrPendingNotExpired($booking, $max_life_pending_booking) {
			
			return ($booking->status == 'confirmed' || ($booking->status == 'pending' && (Carbon::now()->diffInMinutes($booking->created_at)) <= $max_life_pending_booking));
			
		}
	}