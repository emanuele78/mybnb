<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Message;
	use App\Thread;
	use App\User;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class ApartmentThreadController extends Controller {
		
		public function index() {
			
			$validated = request()->validate(['show_by' => ['required', Rule::in(['my_apartment', 'other_apartments'])]]);
			$user = Auth::user();
			if ($validated['show_by'] == 'my_apartment') {
				return Thread::groupedByApartment($user->id);
			}
			return Thread::requestedInfo($user->id);
		}
		
		/**
		 * Show a thread between 2 users
		 *
		 * @param Request $request
		 * @return array
		 */
		public function show(Request $request) {
			
			$validated = $request->validate(
			  [
				'apartment' => 'bail|required|exists:apartments,slug',
				'with' => 'bail|exists:users,nickname',
			  ]);
			$apartment = Apartment::findBySlug($validated['apartment']);
			$currentUser = Auth::user();
			if ($currentUser->owns($apartment->slug)) {
				//user is the owner
				$other_user = User::findByNickname($validated['with']);
				$thread = Message::thread($apartment, $apartment->owner(), $other_user);
			} else {
				//user is NOT the owner
				$thread = Message::thread($apartment, $apartment->owner(), $currentUser);
			}
			$data = [
			  'me' => $currentUser->nickname,
			  'messages' => $thread
			];
			return $data;
		}
	}
