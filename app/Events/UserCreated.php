<?php
	
	namespace App\Events;
	
	use Illuminate\Broadcasting\Channel;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Broadcasting\PrivateChannel;
	use Illuminate\Broadcasting\PresenceChannel;
	use Illuminate\Foundation\Events\Dispatchable;
	use Illuminate\Broadcasting\InteractsWithSockets;
	use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
	
	class UserCreated implements Nameable {
		
		use Dispatchable, InteractsWithSockets, SerializesModels;
		
		/**
		 * Create a new event instance.
		 *
		 * @return void
		 */
		public function __construct() {
			//
		}
		
		public function name(): string {
			return 'USER_CREATED';
		}
	}
