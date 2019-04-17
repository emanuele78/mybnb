<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\StoreBookingRequest;
	use Illuminate\Support\Facades\Auth;
	
	class BookingController extends Controller {
		
		public function create(Apartment $apartment) {
			
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			if (!Auth::user()->customer()->exists()) {
				return redirect()->route('register_customer');
			}
			//user is loggend and registered as a customer
			//need to check if tries to book own apartment
			if ($apartment->user_id == Auth::id()) {
				return redirect()->route('home');
			}
			
			return view('layouts.booking_create')->withApartment($apartment);
			
		}
		
		public function store(StoreBookingRequest $request) {
			
			$validated = $request->validated();
			//todo user_id must be different of apartment_owner_id
			//todo check availability validity
			//todo check if upgrades belong to apartment
			
			//todo after this -> create with status pending
			//todo need to check if exists a pending status for the same user|apartment and replace it
		}
	}