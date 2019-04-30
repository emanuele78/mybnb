<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	
	class ApartmentController extends Controller {
		
		public function index() {
		
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
