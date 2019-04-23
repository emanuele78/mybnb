<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreMessageRequest;
	use Illuminate\Support\Facades\Auth;
	
	class ThreadController extends Controller {
		
		public function index() {
			
			if (!Auth::check()) {
				return redirect()->route('home');
			}
			return view('layouts.threads_index');
		}
		
		public function store(StoreMessageRequest $request) {
			
			
			Message::add($request->validated());
			return response()->json(['success' => true], 200);
			
		}
	}
