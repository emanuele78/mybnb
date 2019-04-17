<?php
	
	namespace App\Http\Controllers;
	
	use App\Services\BraintreeGateway;
	use Illuminate\Support\Facades\Auth;
	
	class PaymentTokenController extends Controller {
		
		public function show(BraintreeGateway $braintreeGateway) {
			
			$user = Auth::user();
			if (!$user->customer()->exists()) {
				return response()->json(['success' => false, 'message' => 'not a customer'], 413);
			}
			$clientToken = $braintreeGateway->clientToken()->generate(
			  [
				"customerId" => $user->customer()->first()->customerId
			  ]);
			return response()->json(['success' => true, 'token' => $clientToken], 200);
		}
	}
