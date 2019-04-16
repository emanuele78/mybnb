<?php
	
	namespace App\Http\Controllers;
	
	use App\Http\Requests\StoreCustomerRequest;
	
	class CustomerController extends Controller {
		
		public function create() {
			
			return view('layouts.customer_create');
		}
		
		public function store(StoreCustomerRequest $request) {
			
			dd($request->validated());
		}
	}
