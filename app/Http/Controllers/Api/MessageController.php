<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Http\Controllers\Controller;
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	use App\Thread;
	use Illuminate\Support\Facades\Auth;
	
	class MessageController extends Controller {
		
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
