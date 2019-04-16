<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	use App\Services\TokenUtil;
	
	class MessageController extends Controller {
		
		private $tokenUtil;
		
		public function __construct(TokenUtil $tokenUtil) {
			
			$this->tokenUtil = $tokenUtil;
		}
		
		public function store(StoreMessageRequest $request) {
			
			$data = $request->validated();
			Message::add(
			  [
				'recipient_apartment_id' => $data['apartment_slug'],
				'sender_user_id' => $data['sender_nickname'],
				'body' => $data['body'],
			  ]);
			return response()->json(['success' => true], 200);
			
		}
	}