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
		
		//		protected $with = ['messages'];
		
		protected $dispatchesEvents = [
		  'created' => UserCreated::class,
		];
		
		public function apartments() {
			
			return $this->hasMany(Apartment::class);
		}
		
		public function messages() {
			
			return $this->hasManyThrough('App\Message', 'App\Apartment', 'user_id', 'recipient_apartment_id', 'id', 'id');
		}
		
		public function bookings() {
			
			return $this->hasMany(Booking::class);
		}
		
		public function isCustomer(): bool {
			
			return $this->customer()->exists();
		}
		
		public function customer() {
			
			return $this->hasOne(Customer::class);
		}
		
		public function customerId() {
			
			return $this->customer->customer_id;
			//todo to be removed
			//		    return $this->customer()->first()->customerId;
		}
	}
