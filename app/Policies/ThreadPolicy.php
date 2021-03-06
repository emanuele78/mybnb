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
		 * @return bool
		 */
		public function view(User $user, Thread $thread) {
			
			return $user->id == $thread->with_user_id || $user->id == $thread->apartment->user_id;
		}
		
		/**
		 * Determine whether the user can add message to a thread
		 *
		 * @param User $user
		 * @param Thread $thread
		 * @return bool
		 */
		public function update(User $user, Thread $thread) {
			
			return $user->id == $thread->with_user_id || $user->id == $thread->apartment->user_id;
		}
		
		/**
		 * Determine whether the user can delete a thread (messages will be hidden for the current user)
		 *
		 * @param User $user
		 * @param Thread $thread
		 * @return bool
		 */
		public function delete(User $user, Thread $thread) {
			
			return $user->id == $thread->with_user_id || $user->id == $thread->apartment->user_id;
		}
		
	}
