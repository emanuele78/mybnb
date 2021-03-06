<?php
	
	namespace App\Http\Controllers;
	
	use App\Token;
	use App\Utility;
	use Illuminate\Support\Facades\Cookie;
	
	class TokenController extends Controller {
		
		/**
		 * Creates a now token from user request
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function store() {
			
			Utility::logEvent('Ask for new App Token');
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
				Cookie::queue(config('project.token_key'), $activatedToken->token_code, config('project.token_expiration_time'));
				$message = 'Token attivato correttamente';
				Utility::logEvent('App Token activated');
			} else {
				Utility::logEvent('Token not valid');
				$message = 'Token non valido';
			}
			return redirect()->route('home')->with('flash_message', $message);
		}
		
	}
