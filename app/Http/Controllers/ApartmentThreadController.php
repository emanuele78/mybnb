<?php
	
	namespace App\Http\Controllers;
	
	use App\Thread;
	use Illuminate\Support\Facades\Auth;
	
	class ApartmentThreadController extends Controller {
		
		/**
		 * Show a view (thread dashboard) where the user can switch between messages received mode and messages sent mode
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function index() {
			
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			return view('layouts.threads_index');
		}
		
		/**
		 * Show the view for a thread between 2 users
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function show() {
			
			$validated = request()->validate(['reference' => 'bail|required|exists:threads,reference_id']);
			if (!Auth::check()) {
				redirect()->route('login');
			}
			$viewData = Thread::getThreadDataFor($validated['reference'], Auth::user()->id);
			if (!$viewData) {
				abort(403);
			}
			return view('layouts.thread_show')->with($viewData);
		}
		
	}
