<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Booking extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $casts = [
		  'check_in' => 'date',
		  'check_out' => 'date',
		];
		
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
	}
