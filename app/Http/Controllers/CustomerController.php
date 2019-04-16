<?php
	
	namespace App\Http\Controllers;
	
	use App\Customer;
	use App\Http\Requests\StoreCustomerRequest;
	use App\Services\BraintreeGateway;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Redirect;
	
	class CustomerController extends Controller {
		
		public function __construct() {
			
			$this->middleware('auth');
		}
		
		public function create() {
			
			return view('layouts.customer_create');
		}
		
		public function store(StoreCustomerRequest $request, BraintreeGateway $braintreeGateway) {
			
			$validated = $request->validated();
			
			$data = [
			  'firstName' => $validated['first_name'],
			  'lastName' => $validated['last_name'],
			  'streetAddress' => $validated['street_address'],
			  'locality' => $validated['street_address'],
			  'postalCode' => $validated['street_address']
			];
			
			$braintree_customer_id = $braintreeGateway->createCustomer($data);
			
			if ($braintree_customer_id) {
				$validated['customer_id'] = $braintree_customer_id;
				$validated['user_id'] = Auth::id();
				Customer::add($validated);
				Redirect::intended();
			}
			dd('errore');
		}
		
	}
