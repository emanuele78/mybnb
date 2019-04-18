<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Customer extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		public static function add($data, $customerId, $userId) {
			$data['customer_id'] = $customerId;
			$data['user_id'] = $userId;
			Customer::create($data);
		}
	}
