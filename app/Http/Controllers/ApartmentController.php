<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\StoreApartmentRequest;
	use App\Http\Requests\UpdateApartmentRequest;
	use App\Service;
	use App\Utility;
	use Auth;
	
	class ApartmentController extends Controller {
		
		private static $max_room_count = 30;
		private static $max_people_count = 30;
		private static $max_bathroom_count = 30;
		
		/**
		 * Go to user apartments dashboard
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
		 */
		public function index() {
			
			Utility::logEvent('Apartments dashboard');
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
			
			Utility::logEvent('Apartment show page');
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
			
			Utility::logEvent('Apartment create page');
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			return view('layouts.apartment_create')
			  ->with('services', Service::findAll())
			  ->with('max_room_value', self::$max_room_count)
			  ->with('max_bathroom_value', self::$max_bathroom_count)
			  ->with('max_people_value', self::$max_people_count);
		}
		
		/**
		 * Save new apartment
		 *
		 * @param StoreApartmentRequest $request
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function store(StoreApartmentRequest $request) {
			
			Utility::logEvent('Save new apartment');
			$validated = $request->validated();
			Apartment::createNew($validated, Auth::user()->id);
			return redirect()->route('apartments_dashboard');
		}
		
		/**
		 * Edit given apartment
		 *
		 * @param Apartment $apartment
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function edit(Apartment $apartment) {
			
			Utility::logEvent('Edit apartment page');
			$this->authorize('update', $apartment);
			return view('layouts.apartment_edit')
			  ->with('apartment', $apartment)
			  ->with('services', $apartment->discoverServices())
			  ->with('max_room_value', self::$max_room_count)
			  ->with('max_bathroom_value', self::$max_bathroom_count)
			  ->with('max_people_value', self::$max_people_count);
		}
		
		/**
		 * Update an apartment
		 *
		 * @param Apartment $apartment
		 * @param UpdateApartmentRequest $request
		 * @return \Illuminate\Http\RedirectResponse
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function update(Apartment $apartment, UpdateApartmentRequest $request) {
			
			Utility::logEvent('Update apartment');
			$this->authorize('update', $apartment);
			$validated = $request->validated();
			$apartment->updateInfo($validated);
			return redirect()->route('apartments_dashboard');
		}
		
	}
