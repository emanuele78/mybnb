<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class ReservedDay extends Model {
		
		public $timestamps = false;
		
		protected $casts = [
		  'day' => 'date',
		];
		
		protected $fillable = ['apartment_id', 'day'];
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		public static function forApartment($apartment_id) {
			
			return ReservedDay::where('apartment_id', $apartment_id)->get();
		}
	}
