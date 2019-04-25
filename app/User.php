<?php
	
	namespace App;
	
	use App\Events\UserCreated;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Laravel\Passport\HasApiTokens;
	
	class User extends Authenticatable {
		
		use HasApiTokens, Notifiable;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $guarded = ['id', 'created_at', 'updated_at'];
		protected $visible = ['nickname', 'messagesSents', 'messagesReceiveds'];
		
		protected $dispatchesEvents = [
		  'created' => UserCreated::class,
		];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function bookings() {
			
			return $this->hasMany(Booking::class);
		}
		
		/**
		 * Check if current user is registered as customer
		 *
		 * @return bool
		 */
		public function isCustomer(): bool {
			
			return $this->customer()->exists();
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasOne
		 */
		public function customer() {
			
			return $this->hasOne(Customer::class);
		}
		
		/**
		 * Return the customer id
		 *
		 * @return mixed
		 */
		public function customerId() {
			
			return $this->customer->customer_id;
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function messagesSents() {
			
			return $this->hasMany('App\Message', 'sender_id', 'id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function messagesReceiveds() {
			
			return $this->hasMany('App\Message', 'recipient_id', 'id');
		}
		
		/**
		 * Generate an array of messages received by the user, grouped by apartments and senders, with unreaded messages flag
		 *
		 * @return array
		 */
		public function apartmentsWithMessages() {
			
			//only user apartments with messages
			$apartmentsWithMessages = $this->apartments()->has('messages')->with('messages')->orderBy('title')->get();
			$results = [];
			foreach ($apartmentsWithMessages as $key => $apartmentsWithMessage) {
				$results[] = [
				  'slug' => $apartmentsWithMessage->slug,
				  'image' => $apartmentsWithMessage->main_image,
				  'title' => $apartmentsWithMessage->title,
				];
				$messages = [];
				$unreaded_messages = false;
				foreach ($apartmentsWithMessage->messages as $key1 => $message) {
					//only messages sent by other users
					if ($this->nickname != $message->sender_id) {
						$index = array_search($message->sender_id, array_column($messages, 'sender'));
						if ($index === false) {
							$messages[] = ['sender' => $message->sender_id, 'unreaded' => $message->unreaded];
						} else {
							$messages[$index]['unreaded'] = $messages[$index]['unreaded'] ?: $message->unreaded;
						}
					}
					$unreaded_messages = $messages[$index]['unreaded'] ? true : $unreaded_messages;
					
				}
				$results[$key]['messages'] = $messages;
				$results[$key]['unreaded_messages'] = $unreaded_messages;
			}
			return $results;
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function apartments() {
			
			return $this->hasMany(Apartment::class);
		}
		
		public function messagesSentForOtherApartments() {
			
			$results = Message::where('sender_id', $this->id)
			  ->with('apartment.user')
			  ->whereHas(
				'apartment.user', function ($query) {
				  
				  $query->where('nickname', '<>', $this->nickname);
			  })
			  ->get();
			$data = [];
			foreach ($results as $result) {
				$index = array_search($result->apartment->slug, array_column($data, 'slug'));
				if ($index === false) {
					$data[] =
					  [
						'slug' => $result->apartment->slug,
						'image' => $result->apartment->main_image,
						'title' => $result->apartment->title,
						'owner' => $result->recipient_id,
						'unreaded_messages' => $result->unreaded,
					  ];
				} else {
					$data[$index]['unreaded_messages'] = $result->unreaded ?: $data[$index]['unreaded_messages'];
				}
			}
			return $data;
		}
		
		/**
		 * Return count of unreaded messages
		 *
		 * @return int
		 */
		public function unreadedMessages(): int {
			
			return Message::where('unreaded', 1)->where('recipient_id', $this->id)->get()->count();
		}
		
		public function owns($apartment_slug): bool {
			
			return $this->apartments()->where('slug', $apartment_slug)->get()->count();
		}
		
		public static function findByNickname($nickname): ?self {
			
			return self::where('nickname', $nickname)->first();
		}
		
	}
