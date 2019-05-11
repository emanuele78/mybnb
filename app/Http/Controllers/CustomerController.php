<?php
	
	namespace App\Http\Controllers;
	
	use App\Customer;
	use App\Http\Requests\StoreCustomerRequest;
	use App\Services\BraintreeGateway;
	use App\Utility;
	use Illuminate\Support\Facades\Auth;
	
	class CustomerController extends Controller {
		
		public function __construct() {
			
			$this->middleware('auth');
		}
		
		/**
		 * Return the form for create new customer
		 * To perform actions like promote apartments or book apartment, logged user has to be a customer providing additional data
		 * These data map the ones stored in braintree server
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function create() {
			
			Utility::logEvent('Show new customer page');
			return view('layouts.customer_create');
		}
		
		/**
		 * Store user tax info
		 *
		 * @param StoreCustomerRequest $request
		 * @param BraintreeGateway $braintreeGateway
		 * @return \Illuminate\Http\RedirectResponse
		 * @throws \Braintree\Exception\NotFound
		 */
		public function store(StoreCustomerRequest $request, BraintreeGateway $braintreeGateway) {
			
			Utility::logEvent('Register customer');
			$validated = $request->validated();
			$response = $braintreeGateway->createCustomer($validated);
			
			if ($response['success']) {
				Customer::add($validated, $response['customer_id'], Auth::id());
				return redirect()->route('home');
			}
			return back()->withErrors(['braintree_message' => $response['message']]);
		}
		
	}
