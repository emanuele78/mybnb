<?php
	
	namespace App\Http\Requests;
	
	use Illuminate\Foundation\Http\FormRequest;
	
	class StoreMessageRequest extends FormRequest {
		
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
			  'apartment_id' => 'bail|required|exists:apartments,slug',
			  'user_id' => 'bail|required|exists:users,nickname',
			  'recipient_id' => 'bail|required|exists:users,nickname|different:user_id',
			  'body' => 'bail|required|min:10|max:4000',
			];
		}
	}
