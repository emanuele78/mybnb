<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class ReservedDay extends Model {
		
		public $timestamps = false;
		
		protected $casts = [
		  'day' => 'date',
		];
		
		protected $fillable = ['apartment_id', 'day'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		/**
		 * Return the reserved day set by the owner. These days cannot be booked by customers
		 *
		 * @param $apartment_id
		 * @return mixed
		 */
		public static function forApartment($apartment_id) {
			
			return ReservedDay::where('apartment_id', $apartment_id)->get();
		}
	}
