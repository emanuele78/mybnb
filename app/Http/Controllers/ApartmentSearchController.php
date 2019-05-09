<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\AdvanceSearchRequest;
	use App\Http\Requests\SimpleSearchRequest;
	use App\Service;
	use App\Traits\CityTrait;
	use App\Traits\SearchValidationTrait;
	
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
		
	}
