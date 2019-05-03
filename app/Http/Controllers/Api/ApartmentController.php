<?php
	
	namespace App\Http\Controllers\Api;
	
	use App\Apartment;
	use App\Http\Controllers\Controller;
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
		
		/**
		 * Destroy the given apartment
		 *
		 * @param Apartment $apartment
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function destroy(Apartment $apartment) {
			
			$apartment->deleteAll();
		}
		
	}
