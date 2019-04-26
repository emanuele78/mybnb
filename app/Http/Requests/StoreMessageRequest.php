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
			
			//user can't send message to himself - anyway I use this check only to prevent some sort of hacking from user
			$apartment = $this->route('apartment');
			return $apartment->user_id != $this->user()->id;
		}
		
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			
			return [
			  'apartment_id' => 'bail|required|exists:apartments,slug',
			  'body' => 'bail|required|min:10|max:4000',
			];
		}
	}
