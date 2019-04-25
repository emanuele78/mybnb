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
		 */
		public function show(Request $request) {
			
			if (!Auth::check()) {
				return abort(403);
			}
			$validated = $request->validate(
			  [
				'apartment' => 'bail|required|exists:apartments,slug',
				'with' => 'bail|exists:users,nickname',
			  ]);
			$apartment = Apartment::findBySlug($validated['apartment']);
			$currentUser = Auth::user();
			if ($currentUser->owns($apartment->slug)) {
				//user is the owner
				$title = "Conversazione per il tuo appartamento";
				$with = ('con');
				$other_user = User::findByNickname($validated['with']);
			} else {
				//user is NOT the owner
				$title = "Conversazione per l'appartamento";
				$with = ('di');
				$other_user = $apartment->user;
			}
			
			return view('layouts.thread_show')
			  ->withTitle($title)
			  ->withWith($with)
			  ->withApartment($apartment)
			  ->withOtherUser($other_user);
		}
	}
