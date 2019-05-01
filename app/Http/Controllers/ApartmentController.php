<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use Auth;
	
	class ApartmentController extends Controller {
		
		public function index() {
			
			if(!Auth::check()){
				return redirect()->route('login');
			}
			return view('layouts.apartment_index');
		}
		
		/**
		 * Return the view apartment show
		 *
		 * @param Apartment $apartment
		 * @return mixed
		 */
		public function show(Apartment $apartment) {
			
			return view('layouts.apartment_show')->withApartment($apartment);
			
		}
		
	}
