<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\Geolocation;
	
	class ApartmentMapController extends Controller {
		
		/**
		 * Return the map for the showed appartment
		 *
		 * @param Apartment $apartment
		 * @param Geolocation $geolocation
		 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
		 */
		public function show(Apartment $apartment, Geolocation $geolocation) {
			
			return $geolocation->getMap($apartment->latitude, $apartment->longitude);
			
		}
	}
