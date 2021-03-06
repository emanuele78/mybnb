<?php
	
	namespace App;
	
	use App\Events\TokenActivated;
	use App\Events\TokenCreated;
	use Illuminate\Database\Eloquent\Model;
	use Carbon\Carbon;
	use Illuminate\Support\Str;
	
	class Token extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		protected $casts = [
		  'expiration' => 'datetime'
		];
		
		protected $dispatchesEvents = [
		  'created' => TokenCreated::class,
		  'updated' => TokenActivated::class,
		];
		
		/**
		 * Checks if provided user token is valid
		 *
		 * @param $user_token
		 * @return bool
		 */
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
			if ($token->expiration->greaterThan(Carbon::now())) {
				return true;
			}
			return false;
		}
		
		/**
		 * Creates a new token
		 *
		 * @param array $data
		 * @return Token|null
		 */
		public static function generate(array $data): ?self {
			
			$data['token_code'] = (string)Str::uuid();
			$token = new Token();
			$token->fill($data);
			$token->save();
			return $token;
		}
		
		/**
		 * Activates provided token
		 *
		 * @param $code
		 * @return Token|null
		 */
		public static function activate($code): ?self {
			
			$token = Token::where('token_code', $code)->first();
			if ($token == null || $token->expiration != null) {
				return null;
			}
			$token->update(['expiration' => Carbon::now()->addMinutes(config('project.token_expiration_time'))]);
			return $token;
		}
		
	}
