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
		
		protected $dispatchesEvents = [
		  'created' => UserCreated::class,
		];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function apartments() {
			
			return $this->hasMany(Apartment::class);
		}
		
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
		public function threads() {
			
			return $this->hasMany('App\Thread', 'created_by', 'id');
		}
		
		//		//todo check
		//		public function messageThreads() {
		//			//		    return
		//		}
		//
		//		public function unreadedMessages() {
		//
		//			return $this->receivedMessages()->where('unreaded', 1)->count();
		//		}
		//
		//		public function sentMessages() {
		//
		//			return $this->hasMany('App\Message', 'sender_user_id', 'id');
		//		}
		//
		//		public function receivedMessages() {
		//
		//			return $this->hasMany('App\Message', 'recipient_user_id', 'id');
		//		}

		//
		//		public function threads() {
		//
		//			return $this->hasManyThrough('App\Message', 'App\Apartment', 'user_id', 'recipient_apartment_id', 'id', 'id');
		//		}
	}
