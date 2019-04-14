<?php
	
	namespace App;
	
	use App\Events\UserCreated;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	
	class User extends Authenticatable {
		
		use Notifiable;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $dispatchesEvents = [
		  'created' => UserCreated::class,
		];
		
		public function apartments() {
			
			return $this->hasMany(Apartment::class);
		}
		
	}
