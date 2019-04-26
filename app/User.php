<?php
	
	namespace App;
	
	use App\Events\UserCreated;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Laravel\Passport\HasApiTokens;
	
	class User extends Authenticatable {
		
		use HasApiTokens, Notifiable;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
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
		public function messagesSent() {
			
			return $this->hasMany(Message::class, 'sender_id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function messagesReceived() {
			
			return $this->hasMany(Message::class, 'recipient_id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function startedThreads() {
			
			return $this->hasMany(Thread::class, 'with_user_id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function apartments() {
			
			return $this->hasMany(Apartment::class);
		}
		
		/**
		 * Find user by his nickname
		 *
		 * @param $nickname
		 * @return User|null
		 */
		public static function findByNickname($nickname): ?self {
			
			return self::where('nickname', $nickname)->first();
		}
		
		/**
		 * Return the number of unreaded messages for the current user
		 *
		 * @return bool
		 */
		public function unreadedMessages(): int {
			
			return Message::where('recipient_id', $this->id)
			  ->where('unreaded', 1)->where(
				function ($query) {
					
					$query->where('visible_for', null)->orWhere('visible_for', $this->id);
				})->get()->count();
		}
	}
