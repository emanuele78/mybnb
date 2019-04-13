<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Promotion extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function promotion_plan() {
			
			return $this->belongsTo(PromotionPlan::class);
		}
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
	}
