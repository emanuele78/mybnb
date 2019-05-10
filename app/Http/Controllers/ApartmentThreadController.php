<?php
	
	namespace App\Http\Controllers;
	
	use App\Thread;
	use App\Utility;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Validation\Rule;
	
	class ApartmentThreadController extends Controller {
		
		/**
		 * Show a view (threads dashboard) where the user can switch between messages received mode and messages sent mode
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function index() {
			
			Utility::logEvent('Messages dashboard');
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			$validated = request()->validate(['show_by' => [Rule::in(['my_apartments', 'other_apartments'])]]);
			if (empty($validated)) {
				$validated = ['show_by' => 'my_apartments'];
			}
			return view('layouts.threads_index')->with($validated);
		}
		
		/**
		 * Show the view for a thread between 2 users
		 *
		 * @param Thread $thread
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function show(Thread $thread) {
			
			Utility::logEvent('Message show page');
			$this->authorize('view', $thread);
			$validated = request()->validate(['show_by' => [Rule::in(['my_apartments', 'other_apartments'])]]);
			if (empty($validated)) {
				$validated = ['show_by' => 'my_apartments'];
			}
			$viewData = $thread->getThreadDataFor(Auth::user()->nickname);
			return view('layouts.thread_show')->with($viewData)->with($validated);
		}
		
	}
