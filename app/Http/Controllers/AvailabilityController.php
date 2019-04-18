<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\ApartmentAvailabilityRequest;
	use Carbon\Carbon;
	use App\Traits\AvailabilityTrait;
	
	class AvailabilityController extends Controller {
		
		use AvailabilityTrait;
		
		public function show(Apartment $apartment, ApartmentAvailabilityRequest $request) {
			
			$check_in = Carbon::createFromFormat('d-m-Y', $request->validated()['check-in']);
			$check_out = Carbon::createFromFormat('d-m-Y', $request->validated()['check-out']);
			return response()->json(['available' => $this->isPeriodAvailable($check_in, $check_out, $apartment)], 200);
		}
	}
