<?php
	
	namespace App\Http\Controllers;
	
	use App\Customer;
	use App\Http\Requests\StoreCustomerRequest;
	use App\Services\BraintreeGateway;
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
			
			request()->session()->has('desired_path') ? request()->session()->flash('desired_path', request()->session()->get('desired_path')) : null;
			return view('layouts.customer_create');
		}
		
		public function store(StoreCustomerRequest $request, BraintreeGateway $braintreeGateway) {
			
			$validated = $request->validated();
			$response = $braintreeGateway->createCustomer($validated);
			
			if ($response['success']) {
				Customer::add($validated, $response['customer_id'], Auth::id());
				if (request()->session()->has('desired_path')) {
					return redirect()->to(request()->session()->get('desired_path'));
				}
				return redirect()->route('home');
			}
			return back()->withErrors(['braintree_message' => $response['message']]);
		}
		
	}
