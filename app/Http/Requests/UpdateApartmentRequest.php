<?php
	
	namespace App\Http\Requests;
	
	use Auth;
	use Illuminate\Foundation\Http\FormRequest;
	
	class UpdateApartmentRequest extends FormRequest {
		
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
			  'title' => 'required|min:10|max:255',
			  'description' => 'required|min:20|max:4000',
			  'address_lat' => 'required',
			  'address_lng' => 'required',
			  'room_count' => 'required|numeric|min:1|max:30',
			  'people_count' => 'required|numeric|min:1|max:30',
			  'bathroom_count' => 'required|numeric|min:1|max:30',
			  'square_meters' => 'required|numeric|min:10',
			  'max_stay' => 'required|numeric|min:1',
			  'price_per_night' => 'required|numeric|min:1',
			  'sale' => 'sometimes|nullable|numeric|min:1|max:99',
			  'is_showed' => 'sometimes|nullable|boolean',
			  'reserved_days' => 'sometimes|nullable|array',
			  'selected_services' => 'sometimes|nullable|array',
			  'selected_services.*' => 'required|exists:services,slug',
			  'services_price' => 'sometimes|nullable|array',
			  'new_services' => 'sometimes|nullable|array',
			  'new_services.*' => 'sometimes|nullable|min:3|max:40',
			  'new_services_prices' => 'sometimes|nullable|array',
			  'main_image' => 'sometimes|image|max:2048|mimes:jpeg,png',
			  'other_images' => 'sometimes|nullable|array|max:4',
			  'other_images.*' => 'required|image|max:2048|mimes:jpeg,png',
			];
		}
		
		public function messages() {
			
			return [
			  'address_lat.required' => 'Missing address',
			  'address_lng.required' => 'Missing address',
			  'new_services.*.min' => 'Service name too short',
			  'new_services.*.max' => 'Service name too long',
			];
		}
	}
