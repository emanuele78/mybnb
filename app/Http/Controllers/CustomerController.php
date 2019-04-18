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
		
		public function create() {
			
			request()->session()->has('desired_path') ? request()->session()->flash('desired_path', request()->session()->get('desired_path')) : null;
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
			
			$response = $braintreeGateway->createCustomer($data);
			
			if ($response['success']) {
				$validated['customer_id'] = $response['customer_id'];
				$validated['user_id'] = Auth::id();
				Customer::add($validated);
				if (request()->session()->has('desired_path')) {
					return redirect()->to(request()->session()->get('desired_path'));
				}
				return redirect()->route('home');
			}
			return back()->withErrors(['braintree_message' => $response['message']]);
		}
		
	}
