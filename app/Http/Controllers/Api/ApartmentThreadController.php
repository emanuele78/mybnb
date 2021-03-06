<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Thread;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class ApartmentThreadController extends Controller {
		
		/**
		 * Return apartment threads data grouped by apartment or all the apartments to which user asked for info
		 *
		 * @return array
		 */
		public function index() {
			
			$validated = request()->validate(['show_by' => ['required', Rule::in(['my_apartments', 'other_apartments'])]]);
			$user = Auth::user();
			if ($validated['show_by'] == 'my_apartments') {
				return Thread::groupedByApartment($user->id);
			}
			return Thread::requestedInfo($user->id);
		}
		
		/**
		 * Return all the exchanged messages between two user in a thread
		 *
		 * @param Thread $thread
		 * @return array
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function show(Thread $thread) {
			
			$this->authorize('view', $thread);
			$thread->setMessagesAsReadForUser(Auth::user());
			return $thread->getMessages(Auth::user());
			
		}
		
		/**
		 * Store new message sent from a thread
		 *
		 * @param Thread $thread
		 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function store(Thread $thread) {
			
			$this->authorize('update', $thread);
			$validated = request()->validate(['body' => 'bail|required|filled|max:4000',]);
			$thread->addMessage(Auth::user(), $validated['body']);
			return response()->json(['success' => true], 200);
		}
		
		/**
		 * Delete a thread
		 *
		 * @param Thread $thread
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function destroy(Thread $thread) {
			
			$this->authorize('delete', $thread);
			$thread->deleteThread(Auth::user());
			return response()->json(['success' => true], 200);
		}
	}
