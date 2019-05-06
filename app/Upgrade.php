<?php
	
	namespace App;
	
	use DB;
	use Illuminate\Database\Eloquent\Model;
	
	class Upgrade extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function service() {
			
			return $this->belongsTo(Service::class);
		}
		
		/**
		 * Replace existing services for the given apartment
		 *
		 * @param $apartment_id
		 * @param $selected_services
		 * @param $selected_services_prices
		 */
		public static function replaceExisting($apartment_id, $selected_services, $selected_services_prices) {
			
			DB::table('upgrades')->where('apartment_id', $apartment_id)->delete();
			self::addExistings($apartment_id, $selected_services, $selected_services_prices);
		}
		
		/**
		 * Attach existing services to given apartment id
		 *
		 * @param $apartment_id
		 * @param $selected_services
		 * @param $selected_services_prices
		 */
		public static function addExistings($apartment_id, $selected_services, $selected_services_prices) {
			
			foreach ($selected_services as $selected_service) {
				self::create(
				  [
					'apartment_id' => $apartment_id,
					'service_id' => Service::findBySlug($selected_service)->id,
					'price_per_night' => $selected_services_prices[$selected_service] == null ? 0 : $selected_services_prices[$selected_service]
				  ]
				);
			}
		}
		
		/**
		 * Attach new services to given apartment id
		 *
		 * @param $apartment_id
		 * @param $new_services
		 * @param $new_services_prices
		 */
		public static function addNew($apartment_id, $new_services, $new_services_prices) {
			
			foreach ($new_services as $new_service) {
				$createdService = Service::addNew($new_service);
				self::create(
				  [
					'apartment_id' => $apartment_id,
					'service_id' => $createdService->id,
					'price_per_night' => $new_services_prices[$new_service] == null ? 0 : $new_services_prices[$new_service]
				  ]
				);
			}
		}
	}
