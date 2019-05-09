<?php
	
	namespace App\Policies;
	
	use App\User;
	use App\Apartment;
	use Illuminate\Auth\Access\HandlesAuthorization;
	
	class ApartmentPolicy {
		
		use HandlesAuthorization;
		
		/**
		 * Determine whether the user can update the apartment.
		 *
		 * @param  \App\User $user
		 * @param  \App\Apartment $apartment
		 * @return mixed
		 */
		public function update(User $user, Apartment $apartment) {
			
			return $user->id === $apartment->owner()->id;
		}
		
		/**
		 * Determine whether the user can delete the apartment.
		 *
		 * @param  \App\User $user
		 * @param  \App\Apartment $apartment
		 * @return mixed
		 */
		public function delete(User $user, Apartment $apartment) {
			
			return $user->id === $apartment->owner()->id;
		}
		
	}
