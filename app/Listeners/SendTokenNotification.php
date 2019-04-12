<?php
	
	namespace App\Listeners;
	
	use App\Events\TokenCreated;
	use App\Mail\TokenMail;
	use Illuminate\Support\Facades\Mail;
	
	class SendTokenNotification {
		
		/**
		 * Create the event listener.
		 *
		 * @return void
		 */
		public function __construct() {
			//
		}
		
		/**
		 * Handle the event.
		 *
		 * @param  TokenCreated $event
		 * @return void
		 */
		public function handle(TokenCreated $event) {
			
			Mail::send(new TokenMail($event->getToken()));
		}
	}
