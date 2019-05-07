<?php
	
	namespace App\Services;
	
	use App\Customer;
	use Braintree_Gateway;
	
	class BraintreeGateway {
		
		private $gateway;
		
		/**
		 * Braintree service constructor
		 *
		 * @param $braintree_config
		 */
		public function __construct($braintree_config) {
			
			if (!config('project.use_fake_data_for_transaction')) {
				$this->gateway = new Braintree_Gateway($braintree_config);
			}
		}
		
		/**
		 * Create a new braintree customer
		 *
		 * @param $data
		 * @return array
		 * @throws \Braintree\Exception\NotFound
		 */
		public function createCustomer($data): array {
			
			if (config('project.use_fake_data_for_transaction')) {
				return ['success' => true, 'customer_id' => Customer::fakeCustomerId()];
			}
			
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
		
		/**
		 * Generate a token for a customer
		 *
		 * @param $customerId
		 * @return string
		 */
		public function customerToken($customerId) {
			
			if (config('project.use_fake_data_for_transaction')) {
				return config('project.client_token_safe');
			}
			
			return $this->gateway->clientToken()->generate(
			  [
				"customerId" => $customerId
			  ]);
		}
		
		/**
		 * Perform the transaction
		 *
		 * @param $amount
		 * @param $nonce
		 * @return bool
		 */
		public function performPayment($amount, $nonce): bool {
			
			if (config('project.use_fake_data_for_transaction')) {
				return true;
			}
			
			$result = $this->gateway->transaction()->sale(
			  [
				'amount' => $amount,
				'paymentMethodNonce' => $nonce,
				'options' => [
				  'submitForSettlement' => true
				]
			  ]);
			return $result->success;
		}
		
	}