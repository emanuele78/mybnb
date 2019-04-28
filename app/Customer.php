<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Customer extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		/**
		 * Add a new customer
		 *
		 * @param $data
		 * @param $customerId
		 * @param $userId
		 */
		public static function add($data, $customerId, $userId) {
			
			$data['customer_id'] = $customerId;
			$data['user_id'] = $userId;
			Customer::create($data);
		}
		
		/**
		 * Return a fake braintree customer id
		 *
		 * @return int
		 */
		public static function fakeCustomerId() {
			
			$lastCustomerId = Customer::select('customer_id')->orderBy('customer_id', 'desc')->take(1)->get()->first();
			if ($lastCustomerId == null) {
				$lastCustomerId = 0;
			}
			return ++$lastCustomerId;
		}
	}
