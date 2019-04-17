<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\Geolocation;
	
	class AddressController extends Controller {
		
		public function show(Apartment $apartment, Geolocation $geolocation) {
			
			return $geolocation->getAddress($apartment->latitude, $apartment->longitude);
			
		}
	}
