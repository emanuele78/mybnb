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
		
		/**
		 * Return the form for the booking
		 *
		 * @param Apartment $apartment
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function create(Apartment $apartment) {
			
			//need some check before proceed
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			if (!Auth::user()->isCustomer()) {
				return redirect()->route('register_customer');
			}
			//user is loggend and registered as a customer
			//need to check if tries to book own apartment
			if ($apartment->user_id == Auth::id()) {
				return redirect()->route('home');
			}
			
			return view('layouts.booking_create')->withApartment($apartment)->withStay($this->parseDate(request()->all()));
			
		}
		
		/**
		 * Helper function to parse user dates if exist
		 *
		 * @param $data
		 * @return array|null
		 */
		private function parseDate($data): ?array {
			
			try {
				return [
				  'check_in' => Carbon::createFromFormat('d-m-Y', $data['check-in'])->format('d-m-Y'),
				  'check_out' => Carbon::createFromFormat('d-m-Y', $data['check-out'])->format('d-m-Y'),
				];
			} catch (\Exception $e) {
				return null;
			}
		}
		
		/**
		 * Save the created booking in pending until payment done
		 *
		 * @param StoreBookingRequest $request
		 * @param Apartment $apartment
		 * @return \Illuminate\Http\RedirectResponse
		 */
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
			if (array_key_exists('upgrades', $validated)) {
				foreach ($validated['upgrades'] as $upgrade) {
					if (!$apartment->hasUpgrade($upgrade)) {
						return redirect()->route('home');
					}
				}
			}
			$booking = Booking::addPendingBooking($validated, $user, $apartment);
			return view('layouts.apartment_payment')->withApartment($apartment)->withReference($booking->reference)->withBookingAmount($booking->bookingAmount());
		}
		
		/**
		 * Return the view where user can switch between booking for own apartments and other apartments
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function index() {
			
			if (!auth::check()) {
				return redirect()->route('login');
			}
			return view('layouts.booking_index');
		}
		
		/**
		 * Show the form with pending booking data
		 *
		 * @param Booking $booking
		 * @return mixed
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function edit(Booking $booking) {
			
			//current user has to be who made the booking and the apartment booking has to be currently registered on the system
			$this->authorize('update', $booking);
			$resumedBooking = $booking->resume();
			return view('layouts.booking_edit')
			  ->withApartment($resumedBooking['apartment'])
			  ->withPendingUpgrades($resumedBooking['pending_upgrades'])
			  ->withStay($resumedBooking['stay']);
		}
	}