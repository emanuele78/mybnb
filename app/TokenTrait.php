<?php
	
	namespace App\Traits;
	
	use App\Mail\TokenMail;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
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
				$token = $request->get($this->token_key);
			} elseif ($request->session()->has($this->token_key)) {
				//check if session has token
				$token = $request->session()->get($this->token_key);
			} else {
				return false;
			}
			$tokenObject = DB::table('tokens')->where('token', $token)->get()->first();
			if ($tokenObject == null) {
				//token not present or not valid
				return false;
			}
			if ($tokenObject->expiration == null) {
				//token need to be activated
				\DB::table('tokens')
				  ->where('token', $token)
				  ->update(['updated_at' => Carbon::now(), 'expiration' => Carbon::now()->addMinutes($this->token_expiration_in_minutes)]);
				$this->saveTokenInSession($token);
				return true;
			}
			//token is valid - need to ckeck expiration
			$expiration = Carbon::create($tokenObject->expiration);
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
				DB::table('tokens')->insert(['token' => $token, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
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