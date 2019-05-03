<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\StoreApartmentRequest;
	use App\Service;
	use Auth;
	
	class ApartmentController extends Controller {
		
		public function index() {
			
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			return view('layouts.apartment_index');
		}
		
		/**
		 * Return the view apartment show
		 *
		 * @param Apartment $apartment
		 * @return mixed
		 */
		public function show(Apartment $apartment) {
			
			return view('layouts.apartment_show')
			  ->withImages($apartment->allRelatedImages())
			  ->withApartment($apartment);
			
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
		 *
		 * @param StoreApartmentRequest $request
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function store(StoreApartmentRequest $request) {
			
			$validated = $request->validated();
			Apartment::createNew($validated, Auth::user()->id);
			return redirect()->route('apartments_dashboard');
		}
		
		public function update() {
		}
		
	}
