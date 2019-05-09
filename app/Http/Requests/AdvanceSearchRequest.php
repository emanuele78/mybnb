<?php
	
	namespace App\Http\Requests;
	
	use Illuminate\Foundation\Http\FormRequest;
	use Illuminate\Validation\Rule;
	use App\Traits\SearchValidationTrait;
	
	class AdvanceSearchRequest extends FormRequest {
		
		use SearchValidationTrait;
		
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize() {
			
			return true;
		}
		
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			
			$rules = $this->baseRules();
			
			$rules['people_count'] = ['required', Rule::in($this->peopleRange())];
			$rules['distance_radius'] = ['required', 'integer', function ($attribute, $value, $fail) {
				
				if ($value < $this->radius_km_data['min'] || $value > $this->radius_km_data['max']) {
					$fail($attribute . ' km radius value not valid');
				}
			}];
			$rules['price_range'] = 'required|array';
			$rules['services'] = 'sometimes|required|array';
			$rules['services.*'] = 'sometimes|required|exists:services,slug';
			$rules['order_by'] = ['required', Rule::in(['distance', 'price_per_night', 'square_meters'])];
			return $rules;
		}
		
		/**
		 * Return array of accepted values for people count rule
		 *
		 * @return array
		 */
		private function peopleRange(): array {
			
			$range = [];
			for ($i = 1; $i <= $this->max_people; $i++) {
				$range[] = $i;
			}
			return $range;
		}
	}
