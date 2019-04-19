<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\TokenUtil;
	use Illuminate\Support\Facades\Config;
	
	class ApartmentController extends Controller {
		
		private $tokenUtil;
		
		public function __construct(TokenUtil $tokenUtil) {
			
			$this->tokenUtil = $tokenUtil;
		}
		
		/**
		 * Returns home page view with promoted apartments, links with major cities
		 * If session doesn't have a valid token, banner is showed
		 *
		 * @return mixed
		 */
		public function index() {
			
			$promotedApartmentToShow = 30;
			return view('layouts.index')
			  ->withHasValidToken($this->tokenUtil->is_allowed())
			  ->withPromotedApartments(Apartment::promoted($promotedApartmentToShow))
			  ->withCitiesCardSizes($this->cardsMatrix())
			  ->withMajorCities($this->majorCities());
		}
		
		/**
		 * Weight distribution for citis cards
		 *
		 * @return array
		 */
		private function cardsMatrix(): array {
			
			return ['big', 'horizontal', 'vertical', 'standard', 'standard', 'standard'];
		}
		
		/**
		 * Return the 20 majors italian cities
		 *
		 * @return array
		 */
		private function majorCities(): array {
			
			$rawData = Config::get('cities');
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
		
		/**
		 * Return the view apartment show
		 *
		 * @param Apartment $apartment
		 * @return mixed
		 */
		public function show(Apartment $apartment) {
			
			return view('layouts.apartment_show')->withApartment($apartment);
			
		}
		
		//todo to be implemented
		public function search() {
			
			return view('layouts.search_results');
		}
		
	}
