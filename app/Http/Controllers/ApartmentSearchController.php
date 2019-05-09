<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\AdvanceSearchRequest;
	use App\Http\Requests\SimpleSearchRequest;
	use App\Service;
	use App\Traits\CityTrait;
	use App\Traits\SearchValidationTrait;
	use Illuminate\Http\Request;
	
	class ApartmentSearchController extends Controller {
		
		use SearchValidationTrait;
		use CityTrait;
		
		/**
		 * Show the form to create new search
		 *
		 * @param SimpleSearchRequest $request
		 * @return mixed
		 */
		public function create(SimpleSearchRequest $request) {
			
			$validated = $request->validated();
			$maxPrice = Apartment::findMaxPrice();
			return view('layouts.search')
			  ->withCitiesList($this->citiesList())
			  ->withMaxPeople($this->max_people)
			  ->withRadiusKmData($this->radius_km_data)
			  ->withPriceRangeData(['min' => 10, 'max' => $maxPrice, 'step' => 10, 'default' => ['start' => 10, 'end' => $maxPrice]])
			  ->withAvailableServices(Service::findAll())
			  ->withUserSearch($validated);
		}
		
		/**
		 * Return the result for a search
		 *
		 * @param AdvanceSearchRequest $request
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function show(AdvanceSearchRequest $request) {
			
			$results_for_page = 10;
			return response()->json(Apartment::search($request->validated(), $results_for_page), 200);
		}
		
		public function test(Request $request) {
			
			$userData = [
			  'city_code' => 1,
			  'check_in' => '20-06-2019',
			  'check_out' => '26-06-2019',
			  'people_count' => 2,
			  'distance_radius' => 100,
			  'price_range' => [10, 150],
			  'services' => []
			];
			return Apartment::search($userData);
		}
		
	}
