<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Carbon\Carbon;
	use Illuminate\Support\Str;
	
	class Token extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public static function isValid($user_token): bool {
			
			$token = Token::where('token_code', $user_token)->first();
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
		
		public static function create(array $data): ?self {
			
			$data['token_code'] = (string)Str::uuid();
			$token = new Token();
			$token->fill($data);
			$token->save();
			return $token;
		}
		
		public static function activate($code): ?self {
			
			$token = Token::where('token_code', $code)->first();
			if ($token == null || $token->expiration != null) {
				return null;
			}
			$token->update(['expiration' => Carbon::now()->addMinutes(config('project.token_expiration_time'))]);
			return $token;
		}
		
	}
