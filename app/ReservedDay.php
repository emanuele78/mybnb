<?php
	
	namespace App;
	
	use DB;
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
		
		/**
		 * Replace the reserved days for the given apartment
		 *
		 * @param $apartment_id
		 * @param $reserved_days
		 */
		public static function replaceDays($apartment_id, $reserved_days) {
			
			DB::table('reserved_days')->where('apartment_id', $apartment_id)->delete();
			self::addDays($apartment_id, $reserved_days);
		}
		
		/**
		 * Reserve days if any
		 *
		 * @param $apartment_id
		 * @param $reserved_days
		 */
		public static function addDays($apartment_id, $reserved_days) {
			
			foreach ($reserved_days as $reserved_day) {
				self::create(['apartment_id' => $apartment_id, 'day' => $reserved_day]);
			}
		}
	}
