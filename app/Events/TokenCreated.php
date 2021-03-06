<?php
	
	namespace App\Events;
	
	use App\Token;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Foundation\Events\Dispatchable;
	use Illuminate\Broadcasting\InteractsWithSockets;
	
	class TokenCreated implements Nameable {
		
		use Dispatchable, InteractsWithSockets, SerializesModels;
		
		private $token;
		
		/**
		 * TokenCreated constructor.
		 *
		 * @param Token $token
		 */
		public function __construct(Token $token) {
			
			$this->token = $token;
		}
		
		/**
		 * Returns the newly created token
		 *
		 * @return Token
		 */
		public function getToken() {
			
			return $this->token;
		}
		
		/**
		 * Returns the name of the current event
		 *
		 * @return string
		 */
		public function name(): string {
			
			return 'TOKEN_CREATED';
		}
	}
