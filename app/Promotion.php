<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Promotion extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Casted field
		 *
		 * @var array
		 */
		protected $casts = [
		  'start_at' => 'datetime',
		  'end_at' => 'datetime',
		];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function promotion_plan() {
			
			return $this->belongsTo(PromotionPlan::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
	}
