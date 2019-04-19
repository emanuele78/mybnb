<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Support\Facades\Auth;
	
	class ThreadController extends Controller {
		
		public function index() {
			
			if (!Auth::check()) {
				return redirect()->route('home');
			}
			return view('layouts.threads_index');
		}
	}
