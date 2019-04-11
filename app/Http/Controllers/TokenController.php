<?php
	
	namespace App\Http\Controllers;
	
	use App\Mail\TokenMail;
	use App\Token;
	use Illuminate\Support\Facades\Mail;
	
	class TokenController extends Controller {
		
		public function store() {
			
			$data = request()->validate(['email' => 'required|email']);
			$token = Token::create($data);
			Mail::send(new TokenMail($token));
			return response()->json([], 200);
		}
		
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
