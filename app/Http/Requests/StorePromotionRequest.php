<?php
	
	namespace App\Http\Requests;
	
	use App\PromotionPlan;
	use Illuminate\Foundation\Http\FormRequest;
	
	class StorePromotionRequest extends FormRequest {
		
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize() {
			
			return $this->user()->id == $this->route('apartment')->owner()->id;
		}
		
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			
			return [
			  'paymentMethodNonce' => 'required',
			  'card_type' => ['required', 'exists:promotion_plans,card_type', function ($attribute, $value, $fail) {
				  
				  if (!PromotionPlan::isActive($value)) {
					  $fail($attribute . ' is not active.');
				  }
			  }],
			  'start_at' => 'string|nullable',
			  'day_length' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) {
				  
				  if (!PromotionPlan::validLength(request()->get('card_type'), $value)) {
					  $fail($attribute . ' day length not valid.');
				  }
				  
			  }],
			
			];
		}
	}
