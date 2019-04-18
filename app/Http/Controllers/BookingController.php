<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Booking;
	use App\Http\Requests\StoreBookingRequest;
	use App\Traits\AvailabilityTrait;
	use Carbon\Carbon;
	use Illuminate\Support\Facades\Auth;
	
	class BookingController extends Controller {
		
		use AvailabilityTrait;
		
		public function create(Apartment $apartment) {
			
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			if (!Auth::user()->isCustomer()) {
				request()->session()->flash('desired_path', request()->fullUrl());
				return redirect()->route('register_customer');
			}
			//user is loggend and registered as a customer
			//need to check if tries to book own apartment
			if ($apartment->user_id == Auth::id()) {
				return redirect()->route('home');
			}
			
			return view('layouts.booking_create')->withApartment($apartment);
			
		}
		
		public function store(StoreBookingRequest $request, Apartment $apartment) {

			$validated = $request->validated();
			$user = Auth::user();
			
			//user id must be different of apartment owner id
			if ($user->id == $apartment->user_id) {
				return redirect()->route('home');
			}
			//check availability validity
			$check_in = Carbon::createFromFormat('d-m-Y', $validated['check_in']);
			$check_out = Carbon::createFromFormat('d-m-Y', $validated['check_out']);
			if (!$this->isPeriodAvailable($check_in, $check_out, $apartment)) {
				return back()->withErrors(['disponibilità' => 'periodo non disponibile']);
			}
			//check if upgrades belong to apartment - maybe user tryed some hack
			if (array_key_exists('upgrades',$validated)) {
				foreach ($validated['upgrades'] as $upgrade) {
					if (!$apartment->hasUpgrade($upgrade)) {
						return redirect()->route('home');
					}
				}
			}
			$booking = Booking::addPendingBooking($validated, $user, $apartment);
			return view('layouts.apartment_payment')->withApartment($apartment)->withReference($booking->reference)->withBookingAmount($booking->bookingAmount());
		}
	}