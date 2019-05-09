<?php
	
	namespace App\Traits;
	
	use Config;
	
	trait CityTrait {
		
		/**
		 * Weight distribution for citis cards
		 *
		 * @return array
		 */
		private function cardsMatrix(): array {
			
			return ['big', 'horizontal', 'vertical', 'standard', 'standard', 'standard'];
		}
		
		/**
		 * Return array of all italian province
		 *
		 * @return array
		 */
		private function citiesList(): array {
			
			$rawData = Config::get('cities');
			$cities = [];
			foreach ($rawData as $index => $data) {
				$cities[] = [
				  'name' => $data['provincia'],
				  'code' => $index
				];
			}
			return $cities;
		}
		
		/**
		 * Return the 20 majors italian cities
		 *
		 * @return array
		 */
		private function majorCities(): array {
			
			$rawData = Config::get('cities');
			$cities = [];
			foreach ($rawData as $index => $data) {
				if (array_key_exists('capoluogo', $data)) {
					$cities[] = [
					  'name' => strtolower($data['provincia']),
					  'code' => $index
					];
				}
			}
			return $cities;
		}
	}