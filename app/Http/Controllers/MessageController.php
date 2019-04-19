<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	
	//todo need to think about it
	class MessageController extends Controller {
		
		//todo move this to thread controller in api namespace
		//todo the endpoint could be
		//todo /threads/{apartment}/messages
		public function store(StoreMessageRequest $request) {
			
			Message::add($request->validated());
			return response()->json(['success' => true], 200);
			
		}
	}