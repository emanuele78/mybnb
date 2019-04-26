<?php
	
	namespace App\Policies;
	
	use App\User;
	use App\Thread;
	use Illuminate\Auth\Access\HandlesAuthorization;
	
	class ThreadPolicy {
		
		use HandlesAuthorization;
		
		/**
		 * Determine whether the user can view the thread.
		 *
		 * @param  \App\User $user
		 * @param  \App\Thread $thread
		 * @return mixed
		 */
		public function view(User $user, Thread $thread) {
			
			return $user->id == $thread->with_user_id || $user->id == $thread->apartment->user_id;
		}
		
	}
