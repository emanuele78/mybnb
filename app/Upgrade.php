<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Upgrade extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function service() {
			
			return $this->belongsTo(Service::class);
		}
	}
