<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class BookedService extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function booking() {
			
			return $this->belongsTo(Booking::class);
		}
	}
