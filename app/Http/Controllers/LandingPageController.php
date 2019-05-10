<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Services\TokenUtil;
	use App\Traits\CityTrait;
	use App\Utility;
	
	class LandingPageController extends Controller {
		
		use CityTrait;
		
		/**
		 * Returns home page view with promoted apartments, links with major cities
		 * If session doesn't have a valid token, banner is showed
		 *
		 * @param TokenUtil $tokenUtil
		 * @return mixed
		 */
		public function index(TokenUtil $tokenUtil) {
			
			Utility::logEvent('Load index');
			$promotedApartmentToShow = 30;
			return view('layouts.index')
			  ->withHasValidToken($tokenUtil->is_allowed())
			  ->withPromotedApartments(Apartment::promoted($promotedApartmentToShow))
			  ->withCitiesCardSizes($this->cardsMatrix())
			  ->withCitiesList($this->citiesList())
			  ->withMajorCities($this->majorCities());
		}
		
	}
