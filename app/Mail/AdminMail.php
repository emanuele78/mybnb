<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Contracts\Queue\ShouldQueue;
	
	class AdminMail extends Mailable {
		
		use Queueable, SerializesModels;
		
		private $event_name;
		
		/**
		 * AdminMail constructor.
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
			
			return $this
			  ->from('mybnb-demo@mybnb.com', config('app.name'))
			  ->to(config('project.admin_email'))
			  ->subject('Nuovo evento server')
			  ->view('mail.admin_mail')
			  ->with(['event' => $this->event_name]);
		}
	}
