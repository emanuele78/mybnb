<?php
	
	use App\Apartment;
	use App\Service;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class UpgradesTableSeeder extends Seeder {
		
		/**
		 * @throws Exception
		 */
		public function run() {
			
			$services_per_apartment = 8;
			$paid_services_per_apartment = 4;
			$services = Service::get();
			if ($services_per_apartment > $services->count()) {
				throw new Exception('$services_per_apartment too high!');
			}
			if ($services_per_apartment < $paid_services_per_apartment ) {
				throw new Exception('$paid_services_per_apartment must be lower or equal than $services_per_apartment!');
			}
			$apartments = Apartment::get();
			$now = Carbon::now();
			foreach ($apartments as $apartment) {
				$services_indexes = [];
				do {
					$index = rand(0, $services->count() - 1);
					if (!in_array($index, $services_indexes)) {
						$services_indexes[] = $index;
					}
				} while (count($services_indexes) < $services_per_apartment);
				foreach ($services_indexes as $key => $services_index) {
					DB::table('upgrades')->insert(
					  [
						'apartment_id' => $apartment->id,
						'service_id' => $services[$services_index]->id,
						'price_per_night' => $key < $paid_services_per_apartment ? rand(5, 10) : 0,
						'created_at' => $now,
						'updated_at' => $now
					  ]);
				}
			}
		}
	}
