<?php
	
	namespace App\Events;
	
	/**
	 * Interface Nameable
	 * Used to send admin notification about occurring event in web app
	 *
	 * @package App\Events
	 */
	interface Nameable {
		
		/**
		 * Return the name of the event
		 *
		 * @return string
		 */
		public function name(): string;
	}