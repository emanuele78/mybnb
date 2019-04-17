<?php
	
	namespace App\Services;
	
	use Braintree_Gateway;
	
	class BraintreeGateway {
		
		private $gateway;
		
		public function __construct($braintree_config) {
			
			$this->gateway = new Braintree_Gateway($braintree_config);
		}
		
		public function createCustomer($data) :array {
			
			$newCustomer = $this->gateway->customer()->create();
			$newCustomerId = $newCustomer->customer->id;
			$data['customerId'] = $newCustomerId;
			$result = $this->gateway->address()->create($data);
			if ($result->success) {
				return ['success' => true, 'customer_id' => $newCustomerId];
			} else {
				//something went wrong
				return ['success' => false, 'message' => $result->message];
			}
		}
		
	}