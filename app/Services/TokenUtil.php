<?php
	
	namespace App\Services;
	
	use App\Token;
	use Illuminate\Support\Facades\Cookie;
	use Illuminate\Support\Facades\Log;
	
	class TokenUtil {
		
		private $token_key_name;
		
		public function __construct($token_key_name) {
			
			$this->token_key_name = $token_key_name;
		}
		
		public function is_allowed() {
			
			if (Cookie::has($this->token_key_name)) {
				$cookie_value = Cookie::get($this->token_key_name);
				if (Token::isValid($cookie_value)) {
					return true;
				}
				return false;
			}
			return false;
		}
	}