<?php
	
	namespace App\Policies;
	
	use App\User;
	use App\Booking;
	use Illuminate\Auth\Access\HandlesAuthorization;
	
	class BookingPolicy {
		
		use HandlesAuthorization;
		
		/**
		 * Determine whether the user can update the booking.
		 *
		 * @param  \App\User $user
		 * @param  \App\Booking $booking
		 * @return mixed
		 */
		public function update(User $user, Booking $booking) {
			
			return $user->id == $booking->user_booking_id && $booking->apartment()->exists();
		}
		
	}
