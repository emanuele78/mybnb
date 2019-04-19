<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Validation\Rule;
	
	//todo should this be ThreadApartmentController????
	class ThreadController extends Controller {
		
		public function index() {
			
			//			$validated = request()->validate(['show_by' => ['required', Rule::in(['apartment', 'date', 'started_by_other', 'started_by_me'])]]);
			//			return request()->get('show_by');
			return 'ciao';
		}
	}
