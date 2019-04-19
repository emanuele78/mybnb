<?php
	
	namespace App\Http\Controllers;
	
	use App\Services\BraintreeGateway;
	use Illuminate\Support\Facades\Auth;
	
	class PaymentTokenController extends Controller {
		
		/**
		 * Send to the client a token related to a braintree customer for a transaction
		 *
		 * @param BraintreeGateway $braintreeGateway
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function show(BraintreeGateway $braintreeGateway) {
			
			$user = Auth::user();
			if (!$user->isCustomer()) {
				return response()->json(['success' => false, 'message' => 'not a customer'], 413);
			}
			$clientToken = $braintreeGateway->customerToken($user->customerId());
			return response()->json(['success' => true, 'token' => $clientToken], 200);
		}
	}
