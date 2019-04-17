<?php
	
	namespace App\Http\Requests;
	
	use Auth;
	use Illuminate\Foundation\Http\FormRequest;
	
	class StoreBookingRequest extends FormRequest {
		
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize() {
			
			return Auth::check();
			
		}
		
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			
			return [
			  'check_in' => 'required|date|after_or_equal:today',
			  'check_out' => 'required|date|after:check-in',
			  'apartment_slug' => 'required|exists:apartments,slug',
			  'upgrades' => 'array',
			  'upgrades.*' => 'exists:services,slug',
			  'special_requests' => 'nullable|min:10|max:4000',
			];
		}
	}
