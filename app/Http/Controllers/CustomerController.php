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
