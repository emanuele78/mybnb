<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Http\Controllers\Controller;
	use App\Http\Requests\StoreApartmentRequest;
	use App\Service;
	use Auth;
	use Illuminate\Validation\Rule;
	
	class ApartmentController extends Controller {
		
		/**
		 * Apartments dashoboard
		 *
		 * @return array
		 */
		public function index() {
			
			$validated = request()->validate(
			  [
				'show' => ['required', Rule::in(['all_apartments', 'only_hidden_apartments', 'only_visible_apartments', 'only_apartments_with_active_promo', 'only_apartments_without_active_promo'])]
			  ]
			);
			$user = Auth::user();
			switch ($validated['show']) {
				case 'only_hidden_apartments':
					$data = Apartment::filterBy($user->id, false, null);
					break;
				case 'only_visible_apartments':
					$data = Apartment::filterBy($user->id, true, null);
					break;
				case 'only_apartments_with_active_promo':
					$data = Apartment::filterBy($user->id, null, true);
					break;
				case 'only_apartments_without_active_promo':
					$data = Apartment::filterBy($user->id, null, false);
					break;
				default:
					//all
					$data = Apartment::filterBy($user->id, null, null);
			}
			return $data;
		}
		
		public function update() {
		}
		
		/**
		 * Show the form to create a new apartment
		 *
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function create() {
			
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			return view('layouts.apartment_create')
			  ->with('services', Service::findAll())
			  ->with('max_room_value', 30)
			  ->with('max_bathroom_value', 30)
			  ->with('max_people_value', 30);
		}
		
		/**
		 * Save new apartment
		 */
		public function store(StoreApartmentRequest $request) {
			
			return $request->validated();
		}
	}
