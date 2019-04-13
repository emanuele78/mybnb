<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class PromotionPlan extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function promotions(){
			return $this->hasMany(Promotion::class);
		}
	}
