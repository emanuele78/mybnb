<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	
	class MessageController extends Controller {
		
		public function store(StoreMessageRequest $request) {
			
			try {
				$validatedData = $request->validated();
				Message::add($validatedData);
				return back()->with('status', true);
			} catch (\Exception $e) {
				return back()->with('status', false);
			}
		}
	}
