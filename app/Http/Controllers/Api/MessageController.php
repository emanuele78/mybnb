<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Http\Controllers\Controller;
	use App\Http\Requests\StoreMessageRequest;
	use App\Message;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class MessageController extends Controller {
		
		public function index() {
			
			$validated = request()->validate(['show_by' => ['required', Rule::in(['my_apartment', 'other_apartments'])]]);
			
			$user = Auth::user();
			if ($validated['show_by'] == 'my_apartment') {
				return $user->apartmentsWithMessages();
			}
			return $user->messagesSentForOtherApartments();
		}
		
		public function store(StoreMessageRequest $request) {
			
			Message::add($request->validated());
			return response()->json(['success' => true], 200);
			
		}
	}
