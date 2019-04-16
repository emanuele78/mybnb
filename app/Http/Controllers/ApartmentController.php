<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\Geolocation;
	use App\Token;
	use Illuminate\Support\Facades\Cookie;
	
	class ApartmentController extends Controller {
		
		/**
		 * Returns home page view with promoted apartments, links with major cities
		 * If session doesn't have a valid token, banner is showed
		 *
		 * @return mixed
		 */
		public function index() {
			$promotedApartmentToShow = 30;
			return view('layouts.index')
			  ->withHasValidToken($this->checkToken())
			  ->withPromotedApartments(Apartment::promoted($promotedApartmentToShow))
			  ->withCardSizes($this->cardsMatrix())
			  ->withMajorCities($this->majorCities());
		}
		
		/**
		 * Check if current session has valid token
		 *
		 * @return bool
		 */
		private function checkToken(): bool {
			
			$token_key_name = config('project.token_key');
			return Cookie::has($token_key_name) ? Token::isValid(Cookie::get($token_key_name)) : false;
		}
		
		private function cardsMatrix(): array {
			
			return ['big', 'horizontal', 'vertical', 'standard', 'standard', 'standard'];
		}
		
		private function majorCities(): array {
			
			$rawData = \Config::get('cities');
			$cities = [];
			foreach ($rawData as $index => $data) {
				if (array_key_exists('capoluogo', $data)) {
					$cities[] = [
					  'name' => strtolower($data['provincia']),
					  'code' => $index
					];
				}
			}
			return $cities;
		}
		
		public function show(Apartment $apartment, Geolocation $geolocation) {
			
			return view('layouts.show')
			  ->withApartment($apartment)
			  ->withAddress($geolocation->getAddress($apartment->latitude, $apartment->longitude))
			  ->withMap($geolocation->getMap($apartment->latitude, $apartment->longitude));
			
		}
		
		public function search() {
			return view('layouts.search_results');
		}
		
		
	}
