<?php
	
	namespace App;
	
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	
	class User extends Authenticatable {
		
		use Notifiable;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function apartments() {
			
			return $this->hasMany(Apartment::class);
		}
		
	}
