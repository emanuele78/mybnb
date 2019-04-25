<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\ShowThreadRequest;
	use App\Message;
	use App\User;
	
	class ApartmentThreadController extends Controller {
		
		public function show(ShowThreadRequest $request) {
			
			$validated = $request->validated();
			$apartment = Apartment::findBySlug($validated['apartment']);
			$other_user = User::findByNickname($validated['with']);
			$thread = Message::thread($apartment, $apartment->owner(), $other_user);
			return view('layouts.thread_show')->withThread($thread)->withApartment($apartment)->withUser($other_user);
		}
	}
