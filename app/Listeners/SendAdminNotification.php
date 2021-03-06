<?php
	
	namespace App\Listeners;
	
	use App\Mail\AdminMail;
	use Illuminate\Support\Facades\Mail;
	
	class SendAdminNotification {
		
		/**
		 * Create the event listener.
		 *
		 * @return void
		 */
		public function __construct() {
			//
		}
		
		/**
		 * Inform admin about the event depends on config settings
		 *
		 * @param  object $event
		 * @return void
		 */
		public function handle($event) {
			
			switch ($event->name()) {
				case 'TOKEN_CREATED':
					if (config('project.notify_token_request')) {
						$this->sendMailToAdmin('richiesta token');
					}
					break;
				case 'TOKEN_ACTIVATED':
					if (config('project.notify_token_activation')) {
						$this->sendMailToAdmin('attivazione token');
					}
					break;
				case 'USER_CREATED':
					if (config('project.notify_user_creation')) {
						$this->sendMailToAdmin('creazione di un nuovo utente');
					}
					break;
				
			}
		}
		
		private function sendMailToAdmin($event_name) {
			
			Mail::send(new AdminMail($event_name));
		}
	}
