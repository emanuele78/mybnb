<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Thread;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class ApartmentThreadController extends Controller {
		
		/**
		 * Return apartment threads grouped by apartment or all the apartments to which user asked for info
		 *
		 * @return array
		 */
		public function index() {
			
			$validated = request()->validate(['show_by' => ['required', Rule::in(['my_apartment', 'other_apartments'])]]);
			$user = Auth::user();
			if ($validated['show_by'] == 'my_apartment') {
				return Thread::groupedByApartment($user->id);
			}
			return Thread::requestedInfo($user->id);
		}
		
		/**
		 * Return all the exchanged messages between two user in a thread
		 *
		 * @param Apartment $apartment
		 * @param Thread $thread
		 * @return array
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function show(Thread $thread) {
			
			$this->authorize('view', $thread);
			//			return Thread::getThreadDataFor($thread->reference_id, Auth::user()->id);
			return $thread->getMessages(Auth::user());
			
		}
		
		/**
		 * Store new message sent from a thread
		 */
		public function store() {
		
		}
	}
