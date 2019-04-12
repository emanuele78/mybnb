<?php
	
	namespace App\Http\Controllers;
	
	use App\Token;
	
	class ApartmentController extends Controller {
		
		/**
		 * Returns home page view with promoted apartments, links with major cities
		 * If session doesn't have a valid token, banner is showed
		 *
		 * @return mixed
		 */
		public function index() {
			
			$token_key_name = config('project.token_key');
			$validToken = request()->session()->has($token_key_name) ? Token::isValid(request()->session()->get($token_key_name)) : false;
			//todo send promo apartments and city links
			return view('layouts.index')->withHasValidToken($validToken);
		}
		
		public function search() {
			
			return view('layouts.search_results');
		}
		
	}
