<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Http\Controllers\Controller;
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	use App\Thread;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class MessageController extends Controller {
		
		//		/**
		//		 * Show all the message sent for own apartments|other apartments
		//		 *
		//		 * @return array
		//		 */
		//		public function index() {
		//
		//			$validated = request()->validate(['show_by' => ['required', Rule::in(['my_apartment', 'other_apartments'])]]);
		//
		//			$user = Auth::user();
		//			if ($validated['show_by'] == 'my_apartment') {
		//				return $user->apartmentsWithMessages();
		//			}
		//			return $user->messagesSentForOtherApartments();
		//		}
		
		/**
		 * Save a newly created message for the given apartment
		 *
		 * @param StoreMessageRequest $request
		 * @param Apartment $apartment
		 */
		public function store(StoreMessageRequest $request, Apartment $apartment) {
			
			$validatd = $request->validated();
			//get the thread for the sent message or create a new one if not exists
			$thread = Thread::addIfNotExists($apartment->id, Auth::user()->id);
			//store the new message
			Message::add(
			  [
				'thread_id' => $thread->id,
				'sender_id' => Auth::user()->id,
				'recipient_id' => $apartment->user_id,
				'body' => $validatd['body']
			  ]
			);
			response()->json(['success' => true], 200);
		}
	}
