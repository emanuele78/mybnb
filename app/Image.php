<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Image extends Model {
		
		protected $fillable = ['name', 'apartment_id'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
	}
