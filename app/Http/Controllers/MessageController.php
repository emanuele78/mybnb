<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	
	class MessageController extends Controller {
		
		public function store(StoreMessageRequest $request) {
			
			$data = $request->validated();
			Message::add(
			  [
				'recipient_apartment_id' => $data['apartment_slug'],
				'sender_user_id' => $data['sender_nickname'],
				'body' => $data['body'],
			  ]);
			return response()->json(['status' => true], 200);
			
		}
	}
	
	//http://127.0.0.1:8000/test?apartment_slug=perspiciatis-eum-ut-odit&sender_nickname=Anissa&recipient_nickname=Madge&body=ciao-come-stai