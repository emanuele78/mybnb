<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Contracts\Queue\ShouldQueue;
	
	class TokenMail extends Mailable {
		use Queueable, SerializesModels;
		
		private $token;
		private $time;
		private $url;
		
		/**
		 * Create a new message instance.
		 *
		 * @return void
		 */
		public function __construct($token, $time, $url) {
			$this->token = $token;
			$this->url = $url;
			$this->time = $time;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build() {
			return $this->from('info@emanuelemazzante.dev', 'Emanuele Mazzante')
			  ->subject('Ecco il tuo token!')
			  ->view('mail.token_mail')
			  ->with(['url' => $this->url, 'token' => $this->token, 'time_length' => $this->time]);
		}
	}
