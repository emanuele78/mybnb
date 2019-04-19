<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class BookedService extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function booking() {
			
			return $this->belongsTo(Booking::class);
		}
	}
