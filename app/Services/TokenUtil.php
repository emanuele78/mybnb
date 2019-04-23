<?php
	
	namespace App\Services;
	
	use App\Token;
	use Illuminate\Support\Facades\Cookie;
	
	class TokenUtil {
		
		private $token_key_name;
		
		/**
		 * Constructon utility service to check token app existence
		 *
		 * @param $token_key_name
		 */
		public function __construct($token_key_name) {
			
			$this->token_key_name = $token_key_name;
		}
		
		/**
		 * Check if there is a cokie with app token
		 *
		 * @return bool
		 */
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