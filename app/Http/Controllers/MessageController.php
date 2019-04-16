<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	use App\Services\TokenUtil;
	use Illuminate\Support\Facades\Cookie;
	
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
	
	//http://127.0.0.1:8000/test?apartment_slug=perspiciatis-eum-ut-odit&sender_nickname=Anissa&recipient_nickname=Madge&body=ciao-come-stai