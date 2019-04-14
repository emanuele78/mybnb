<?php
	
	use App\Apartment;
	use Illuminate\Database\Seeder;
	use Carbon\Carbon;
	
	class ImagesTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$images_per_apartment = 3;
			$imageNames = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.jpg', 'image6.jpg', 'image7.jpg', 'image8.jpg', 'image9.jpg', 'image10.jpg'];
			$apartments = Apartment::get();
			$now = Carbon::now();
			foreach ($apartments as $apartment) {
				$images_indexes = [];
				do {
					$index = rand(0, count($imageNames) - 1);
					if (!in_array($index, $images_indexes)) {
						$images_indexes[] = $index;
					}
				} while (count($images_indexes) < $images_per_apartment);
				foreach ($images_indexes as $images_index) {
					DB::table('images')->insert(
					  [
						'apartment_id' => $apartment->id,
						'name' => $imageNames[$images_index],
						'created_at' => $now,
						'updated_at' => $now
					  ]);
				}
			}
		}
	}
