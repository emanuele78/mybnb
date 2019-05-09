<?php
	
	namespace App\Traits;
	
	use Carbon\Carbon;
	use Illuminate\Validation\Rule;
	
	trait SearchValidationTrait {
		
		protected $max_people = 10;
		protected $radius_km_data = ['min' => 10, 'max' => 100, 'step' => 1, 'default' => 20];
		
		/**
		 * Base rules for a search. These are shared between simple search and advance search
		 *
		 * @return array
		 */
		private function baseRules() {
			
			return [
			  'city_code' => ['required', function ($attribute, $value, $fail) {
				  
				  if ($value < 0 || $value > count(config('cities'))) {
					  
					  $fail($attribute . ' city not in list');
				  }
			  }],
			  'check_in' => ['nullable', 'date_format:d-m-Y', Rule::requiredIf(
				function () {
					
					return $this->request->get('check_out');
				}), function ($attribute, $value, $fail) {
				  
				  $checkInDate = Carbon::createFromFormat('d-m-Y', $value);
				  $checkOutDate = Carbon::createFromFormat('d-m-Y', $this->request->get('check_out'));
				  if ($checkInDate->greaterThanOrEqualTo($checkOutDate)) {
					  $fail($attribute . ' must be less than check-out');
				  }
				  if ($checkInDate->diffInDays(Carbon::now()) < 0) {
					  $fail($attribute . ' in the past');
				  }
			  }],
			  'check_out' => ['nullable', 'date_format:d-m-Y', Rule::requiredIf(
				function () {
					
					return $this->request->get('check_in');
				})],
			];
		}
	}