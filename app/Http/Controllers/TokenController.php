<?php
	
	namespace App\Http\Controllers;
	
	use App\Token;
	
	class TokenController extends Controller {
		
		/**
		 * Creates a now token from user request
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function store() {
			$data = request()->validate(['email' => 'required|email']);
			Token::generate($data);
			return response()->json([], 200);
		}
		
		/**
		 * Activates a token passed by web form or email link then redirects to home page
		 *
		 * @param $code
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function update($code) {
			
			$activatedToken = Token::activate($code);
			if ($activatedToken) {
				session([config('project.token_key') => $activatedToken->token_code]);
				$message = 'Token attivato correttamente';
			} else {
				$message = 'Token non valido';
			}
			return redirect()->route('home')->with('flash_message', $message);
		}
		
	}
