<?php
	
	namespace App\Http\Requests;
	
	use Auth;
	use Illuminate\Foundation\Http\FormRequest;
	
	class ShowThreadRequest extends FormRequest {
		
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize() {
			
			$apartment = request()->get('apartment');
			return Auth::check() && $this->user()->owns($apartment);
		}
		
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			
			return [
			  'apartment' => 'bail|required|exists:apartments,slug',
			  'with' => 'bail|required|exists:users,nickname',
			];
		}
	}
