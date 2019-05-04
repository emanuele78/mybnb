<?php
	
	namespace App\Policies;
	
	use App\User;
	use App\Booking;
	use Illuminate\Auth\Access\HandlesAuthorization;
	
	class BookingPolicy {
		
		use HandlesAuthorization;
		
		//		/**
		//		 * Determine whether the user can view the booking.
		//		 *
		//		 * @param  \App\User $user
		//		 * @param  \App\Booking $booking
		//		 * @return mixed
		//		 */
		//		public function view(User $user, Booking $booking) {
		//			//
		//		}
		//
		//		/**
		//		 * Determine whether the user can create bookings.
		//		 *
		//		 * @param  \App\User $user
		//		 * @return mixed
		//		 */
		//		public function create(User $user) {
		//			//
		//		}
		
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
		
		//		/**
		//		 * Determine whether the user can delete the booking.
		//		 *
		//		 * @param  \App\User $user
		//		 * @param  \App\Booking $booking
		//		 * @return mixed
		//		 */
		//		public function delete(User $user, Booking $booking) {
		//			//
		//		}
		//
		//		/**
		//		 * Determine whether the user can restore the booking.
		//		 *
		//		 * @param  \App\User $user
		//		 * @param  \App\Booking $booking
		//		 * @return mixed
		//		 */
		//		public function restore(User $user, Booking $booking) {
		//			//
		//		}
		//
		//		/**
		//		 * Determine whether the user can permanently delete the booking.
		//		 *
		//		 * @param  \App\User $user
		//		 * @param  \App\Booking $booking
		//		 * @return mixed
		//		 */
		//		public function forceDelete(User $user, Booking $booking) {
		//			//
		//		}
	}
