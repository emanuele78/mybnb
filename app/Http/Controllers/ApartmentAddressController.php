<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\Geolocation;
	
	class ApartmentAddressController extends Controller {
		
		/**
		 * Reverse geo: given geo-coordinates return the address
		 *
		 * @param Apartment $apartment
		 * @param Geolocation $geolocation
		 * @return array
		 * @throws \GuzzleHttp\Exception\GuzzleException
		 */
		public function show(Apartment $apartment, Geolocation $geolocation) {
			
			return $geolocation->getAddress($apartment->latitude, $apartment->longitude);
			
		}
	}
