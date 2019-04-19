<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\ApartmentAvailabilityRequest;
	use Carbon\Carbon;
	use App\Traits\AvailabilityTrait;
	
	class ApartmentAvailabilityController extends Controller {
		
		use AvailabilityTrait;
		
		/**
		 * Return the availability for an appartment
		 *
		 * @param Apartment $apartment
		 * @param ApartmentAvailabilityRequest $request
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function show(Apartment $apartment, ApartmentAvailabilityRequest $request) {
			
			$check_in = Carbon::createFromFormat('d-m-Y', $request->validated()['check-in']);
			$check_out = Carbon::createFromFormat('d-m-Y', $request->validated()['check-out']);
			return response()->json(['available' => $this->isPeriodAvailable($check_in, $check_out, $apartment)], 200);
		}
	}
