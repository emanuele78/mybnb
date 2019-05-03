<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Http\Controllers\Controller;
	
	class ApartmentVisibilityController extends Controller {
		
		/**
		 * Update the visibility of the apartment
		 *
		 * @param Apartment $apartment
		 * @return \Illuminate\Http\JsonResponse
		 * @throws \Illuminate\Auth\Access\AuthorizationException
		 */
		public function update(Apartment $apartment) {
			
			$this->authorize('update', $apartment);
			$validated = request()->validate(['is_showed' => 'required|boolean']);
			$apartment->visibility($validated['is_showed']);
			return response()->json(['success' => true], 200);
		}
	}
