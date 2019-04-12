<?php
	
	namespace App\Events;
	
	interface Nameable {
		
		public function name(): string;
	}