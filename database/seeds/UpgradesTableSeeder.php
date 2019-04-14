<?php
	
	use App\Apartment;
	use App\Service;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class UpgradesTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$services_per_apartment = 3;
			$services = Service::get();
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
				foreach ($services_indexes as $services_index) {
					DB::table('upgrades')->insert(
					  [
						'apartment_id' => $apartment->id,
						'service_id' => $services[$services_index]->id,
						'price_per_night' => $services_index < 5 ? 0 : 5,
						'created_at' => $now,
						'updated_at' => $now
					  ]);
				}
			}
		}
	}
