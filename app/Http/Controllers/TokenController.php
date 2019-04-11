<?php
	
	namespace App\Http\Controllers;
	
	use App\Mail\TokenMail;
	use App\Token;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Mail;
	
	class TokenController extends Controller {
		
		//		protected $tokenRepo;
		//
		//		public function __construct(TokenRepoInterface $tokenRepo) {
		//			$this->tokenRepo = $tokenRepo;
		//		}
		//
		//		public function requestNewToken(Request $request) {
		//			try {
		//				$new_token = $this->tokenRepo->generateNewToken($request->email);
		//				$errors = $this->tokenRepo->errors();
		//				if (empty($errors)) {
		//					$this->sendToken($new_token, $request->email);
		//					return response()->json(['message' => 'E\' stato inviato un token all\'indirizzo inserito'], 200);
		//				} else {
		//					return response()->json(['message' => 'Indirizzo email non valido'], 400);
		//				}
		//			} catch (\Exception $e) {
		//				return response()->json(['message' => 'Errore durante l\'elaborazione della richiesta'], 500);
		//			}
		//		}
		//
		//		private function sendToken($token, $recipient) {
		//			if (config('project.use_test_recipient')) {
		//				$recipient = config('project.test_recipient_mail');
		//			}
		//			$url = route('activate-token', [config('project.token_key') => $token]);
		//			Mail::to($recipient)->send(new TokenMail($token, config('project.token_expiration_time'), $url));
		//		}
		//
		//		public function activateToken(Request $request) {
		//			return redirect()->route('home');
		//		}
		
		public function store() {
			
			$data = request()->validate(['email' => 'required|email']);
			Token::create($data);
			return response()->json([], 200);
		}
		
	}
