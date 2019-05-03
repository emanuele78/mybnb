<?php
	
	namespace App\Policies;
	
	use App\User;
	use App\Apartment;
	use Illuminate\Auth\Access\HandlesAuthorization;
	
	class ApartmentPolicy {
		
		use HandlesAuthorization;
		
		//    /**
		//     * Determine whether the user can view the apartment.
		//     *
		//     * @param  \App\User  $user
		//     * @param  \App\Apartment  $apartment
		//     * @return mixed
		//     */
		//    public function view(User $user, Apartment $apartment)
		//    {
		//        //
		//    }
		//
//		/**
//		 * Determine whether the user can create apartments.
//		 *
//		 * @param  \App\User $user
//		 * @return mixed
//		 */
//		public function create(User $user) {
//
//			return $user != null;
//		}
		
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
		
		//    /**
		//     * Determine whether the user can delete the apartment.
		//     *
		//     * @param  \App\User  $user
		//     * @param  \App\Apartment  $apartment
		//     * @return mixed
		//     */
		//    public function delete(User $user, Apartment $apartment)
		//    {
		//        //
		//    }
		//
		//    /**
		//     * Determine whether the user can restore the apartment.
		//     *
		//     * @param  \App\User  $user
		//     * @param  \App\Apartment  $apartment
		//     * @return mixed
		//     */
		//    public function restore(User $user, Apartment $apartment)
		//    {
		//        //
		//    }
		//
		//    /**
		//     * Determine whether the user can permanently delete the apartment.
		//     *
		//     * @param  \App\User  $user
		//     * @param  \App\Apartment  $apartment
		//     * @return mixed
		//     */
		//    public function forceDelete(User $user, Apartment $apartment)
		//    {
		//        //
		//    }
	}
