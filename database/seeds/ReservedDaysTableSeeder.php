<?php
	
	use App\Apartment;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class ReservedDaysTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			if (!config('project.use_debug_mode_when_seeding')) {
				$this->seedForProductionDemo();
				return;
			}
			$apartments = Apartment::get();
			$first_day_reserved = Carbon::now()->addDays(3);
			$second_day_reserved = Carbon::now()->addDays(6);
			$third_day_reserved = Carbon::now()->addDays(9);
			foreach ($apartments as $apartment) {
				DB::table('reserved_days')->insert(
				  [
					[
					  'day' => $first_day_reserved,
					  'apartment_id' => $apartment->id
					],
					[
					  'day' => $second_day_reserved,
					  'apartment_id' => $apartment->id
					],
					[
					  'day' => $third_day_reserved,
					  'apartment_id' => $apartment->id
					]
				  ]
				);
			}
		}
		
		private function seedForProductionDemo() {
			
			$apartments = Apartment::get();
			$fixedToAdd = 10;
			foreach ($apartments as $apartment) {
				$randFromNow = rand(5, 30);
				$first_day_reserved = Carbon::now()->addDays($randFromNow);
				$second_day_reserved = Carbon::now()->addDays($randFromNow + $fixedToAdd);
				DB::table('reserved_days')->insert(
				  [
					[
					  'day' => $first_day_reserved,
					  'apartment_id' => $apartment->id
					],
					[
					  'day' => $second_day_reserved,
					  'apartment_id' => $apartment->id
					]
				  ]
				);
			}
		}
	}
