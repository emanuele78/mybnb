<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Traits\TokenTrait;
	
	class ApartmentController extends Controller {
		
		use TokenTrait;
		
		public function index(Request $request) {
			$hasValidToken = $this->isValidToken($request);
			return view('layouts.index')->withHasValidToken($hasValidToken);
		}
		
		
	}
