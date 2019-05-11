<?php
	
	namespace App\Http\Requests;
	
	use Illuminate\Foundation\Http\FormRequest;
	
	class StoreCustomerRequest extends FormRequest {
		
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
			
			return [
			  'firstName' => 'bail|required|string|between:2,100',
			  'lastName' => 'bail|required|string|between:2,100',
			  'streetAddress' => 'bail|required|string|between:2,100',
			  'locality' => 'bail|required|string|between:2,100',
			  'postalCode' => 'bail|required|numeric',
			  'taxCode' => 'bail|required|string|size:16',
			];
		}
	}
