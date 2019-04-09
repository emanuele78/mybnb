<?php
	
	namespace App\Traits;
	
	use App\Mail\TokenMail;
	use App\Token;
	use Illuminate\Http\Request;
	use Carbon\Carbon;
	use Illuminate\Support\Str;
	use Validator;
	use Illuminate\Support\Facades\Mail;
	
	trait TokenTrait {
		
		private $token_expiration_in_minutes;
		private $token_key;
		
		public function __construct() {
			$this->token_expiration_in_minutes = config('project.token_expiration_time');
			$this->token_key = config('project.token_key');
		}
		
		public function isValidToken(Request $request): bool {
			if ($request->has($this->token_key)) {
				//check if request har url encoded token
				$user_token = $request->get($this->token_key);
			} elseif ($request->session()->has($this->token_key)) {
				//check if session has token
				$user_token = $request->session()->get($this->token_key);
			} else {
				return false;
			}
			$token = Token::where('token', $user_token)->first();
			if ($token == null) {
				//token not present or not valid
				return false;
			}
			if ($token->expiration == null) {
				//token need to be activated
				$token->expiration = Carbon::now()->addMinutes($this->token_expiration_in_minutes);
				$token->save();
				$this->saveTokenInSession($user_token);
				return true;
			}
			//token is valid - need to ckeck expiration
			$expiration = Carbon::create($token->expiration);
			return $expiration->greaterThan(Carbon::now());
		}
		
		private function saveTokenInSession($token): void {
			session([$this->token_key => $token]);
		}
		
		public function requestNewToken(Request $request) {
			try {
				$validator = Validator::make(
				  $request->all(), [
				  'email' => 'required|email',
				]);
				if ($validator->fails()) {
					throw new \InvalidArgumentException();
				}
				//creating token and saving it in DB without expiration date-time
				$token = (string)Str::uuid();
				Token::create(['token' => $token]);
				//sending mail
				$this->sendTokenEmail($token, $validator->validated()['email']);
				return response()->json(['message' => 'E\' stato inviato un token all\'indirizzo inserito'], 200);
			} catch (\InvalidArgumentException $e) {
				return response()->json(['message' => 'Indirizzo email non valido'], 400);
			} catch (\Exception $e) {
				return response()->json(['message' => 'Errore durante l\'elaborazione della richiesta'], 500);
			}
		}
		
		private function sendTokenEmail($token, $recipient) {
			if (config('project.use_test_recipient')) {
				$recipient = config('project.test_recipient_mail');
			}
			$url = route('home', [$this->token_key => $token]);
			Mail::to($recipient)->send(new TokenMail($token, $this->token_expiration_in_minutes, $url));
		}
	}