<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\Geolocation;
	
	class MapController extends Controller {
		
		public function show(Apartment $apartment, Geolocation $geolocation) {
			
			return $geolocation->getMap($apartment->latitude, $apartment->longitude);
			
		}
	}
