<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Carbon\Carbon;
	use Illuminate\Support\Str;
	
	class Token extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		//		protected $token;
		//		protected $token_expiration_in_minutes;
		//		protected $token_key;
		//		protected $validation_rules = [
		//		  'email' => 'required|email',
		//		  'token' => 'required|string|unique:tokens',
		//		  'expiration' => 'data|nullable',
		//		];
		
		//		public function __construct(Token $token) {
		//						$this->token = $token;
		//			$this->token_expiration_in_minutes = config('project.token_expiration_time');
		//			$this->token_key = config('project.token_key');
		//		}
		
		//		public function checkToken(string $user_token): int {
		//			$token = Token::where('token', $user_token)->first();
		//			if ($token == null) {
		//				//token not present
		//				return Constants::NOT_VALID_TOKEN;
		//			}
		//			if ($token->expiration == null) {
		//				return Constants::FRESH_TOKEN;
		//			}
		//			//token is valid - need to check expiration
		//			$expiration = Carbon::create($token->expiration);
		//			if ($expiration->greaterThan(Carbon::now())) {
		//				return Constants::VALID_TOKEN;
		//			}
		//			return Constants::EXPIRED_TOKEN;
		//		}
		
		//		public function generateNewToken(?string $email): string {
		//			$data = ['token' => (string)Str::uuid(), 'email' => $email];
		//			$token = new Token();
		//			if ($this->validate($data)) {
		//				$token->token = $data['token'];
		//				$token->save();
		//			}
		//			return $data['token'];
		//		}
		
		//		public function errors(): array {
		//			return $this->errors == null ? [] : $this->errors->toArray();
		//		}
		
		//todo new
		public static function isValid($user_token): bool {
			
			$token = Token::where('token', $user_token)->first();
			if ($token == null) {
				//token not present
				return false;
			}
			if ($token->expiration == null) {
				return false;
			}
			//token is valid - need to check expiration
			$expiration = Carbon::create($token->expiration);
			if ($expiration->greaterThan(Carbon::now())) {
				return true;
			}
			return false;
		}
		
		public static function create(array $data) {
			
			$data['token'] = (string)Str::uuid();
			$token = new Token();
			$token->fill($data);
			$token->save();
			return $token;
		}
		
	}
