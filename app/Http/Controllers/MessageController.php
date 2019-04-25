<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	
	class MessageController extends Controller {
		
		public function index() {
			
			if (!Auth::check()) {
				return redirect()->route('home');
			}
			return view('layouts.threads_index');
		}
		
		public function show(Request $request) {
			dd($request->all());
		}
	}