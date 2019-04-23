<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	
	class AdminMail extends Mailable {
		
		use Queueable, SerializesModels;
		
		private $event_name;
		
		/**
		 * Construnct a mailable object used for admin notifcation
		 *
		 * @param string $event_name
		 */
		public function __construct(string $event_name) {
			
			$this->event_name = $event_name;
		}
		
		/**
		 * Builds the message
		 *
		 * @return AdminMail
		 */
		public function build() {
			
			if (config('project.use_test_recipient_for_admin')) {
				$admin = config('project.test_recipient_mail');
			} else {
				$admin = config('project.admin_email');
			}
			return $this
			  ->from('mybnb-demo@mybnb.com', config('app.name'))
			  ->to($admin)
			  ->subject('Nuovo evento server')
			  ->view('mail.admin_mail')
			  ->with(['event' => $this->event_name]);
		}
	}
