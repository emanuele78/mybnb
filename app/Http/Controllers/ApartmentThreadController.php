<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Message;
	use App\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	
	class ApartmentThreadController extends Controller {
		
		/**
		 * Show a view where the user can switch between messages received mode and messages sent mode
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function index() {
			
			if (!Auth::check()) {
				return redirect()->route('home');
			}
			return view('layouts.threads_index');
		}
		
		/**
		 * Show a thread between 2 users
		 *
		 * @param Request $request
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function show(Request $request) {
			
			if (!Auth::check()) {
				abort(403);
			}
			$validated = $request->validate(
			  [
				'apartment' => 'bail|required|exists:apartments,slug',
				'with' => 'bail|exists:users,nickname',
			  ]);
			$viewData = $this->getThreadOrFail($validated);
			if ($viewData == null) {
				abort(403);
			}
			return view('layouts.thread_show')->with($viewData);
		}
		
		private function getThreadOrFail($validated) {
			
			$apartment = Apartment::findBySlug($validated['apartment']);
			$currentUser = Auth::user();
			if ($currentUser->owns($apartment->slug)) {
				if (!array_key_exists('with', $validated)) {
					return null;
				}
				//user is the owner
				$title = "Conversazione per il tuo appartamento";
				$with = ('con');
				$other_user = User::findByNickname($validated['with']);
				//security check
				if (!Message::threadExist($apartment->id, $currentUser->id, $other_user->id)) {
					return null;
				}
			} else {
				//user is NOT the owner
				$title = "Conversazione per l'appartamento";
				$with = ('di');
				$other_user = $apartment->user;
			}
			
			return ['title' => $title, 'with' => $with, 'apartment' => $apartment, 'otherUser' => $other_user];
		}
	}
