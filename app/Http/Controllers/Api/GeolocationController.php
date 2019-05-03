<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Http\Controllers\Controller;
	use App\Services\Geolocation;
	
	class GeolocationController extends Controller {
		
		/**
		 * Return a list of addresses
		 *
		 * @param Geolocation $geolocation
		 * @return array|mixed|\Psr\Http\Message\ResponseInterface
		 * @throws \GuzzleHttp\Exception\GuzzleException
		 */
		public function index(Geolocation $geolocation) {
			
			$validated = request()->validate(['input' => 'required|min:5']);
			return $geolocation->searchAddress($validated['input']);
			
		}
		
		/**
		 * Return a map for the given coordinates
		 *
		 * @param Geolocation $geolocation
		 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
		 * @throws \GuzzleHttp\Exception\GuzzleException
		 */
		public function show(Geolocation $geolocation) {
			
			$validated = request()->validate(['lat' => 'required|numeric|between:-90,90', 'lng' => 'required|numeric|between:-180,180']);
			return $geolocation->getMap($validated['lat'], $validated['lng']);
		}
		
	}
