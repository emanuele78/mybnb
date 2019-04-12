<?php
	
	namespace App\Events;
	
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Foundation\Events\Dispatchable;
	use Illuminate\Broadcasting\InteractsWithSockets;
	
	class TokenActivated implements Nameable {
		
		use Dispatchable, InteractsWithSockets, SerializesModels;
		
		/**
		 * Create a new event instance.
		 *
		 * @return void
		 */
		public function __construct() {
			//
		}
		
		/**
		 * Returns the name of the current event
		 *
		 * @return string
		 */
		public function name(): string {
			return 'TOKEN_ACTIVATED';
		}
	}
