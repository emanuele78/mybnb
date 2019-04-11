<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Contracts\Queue\ShouldQueue;
	
	class TokenMail extends Mailable {
		use Queueable, SerializesModels;
		
		private $token;
		private $url;
		
		/**
		 * Create a new message instance.
		 *
		 * @return void
		 */
		public function __construct($token) {
			
			$this->token = $token;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build() {
			$url = route('activate-token', [config('project.token_key') => $this->token->token_code]);
			return $this
			  ->from(config('project.token_email_from_email'), config('project.token_email_from_name'))
			  ->to(config('project.use_test_recipient') ? config('project.test_recipient_mail') : $this->token->email)
			  ->subject('Il tuo token')
			  ->view('mail.token_mail')
			  ->with(['url' => $url, 'token' => $this->token->token_code, 'time_length' => config('project.token_expiration_time')]);
		}
	}
