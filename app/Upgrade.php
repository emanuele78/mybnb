<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Upgrade extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		public function service() {
			
			return $this->belongsTo(Service::class);
		}
	}
