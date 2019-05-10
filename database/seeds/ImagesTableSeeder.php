<?php
	
	use App\Apartment;
	use App\Image;
	use Illuminate\Database\Seeder;
	
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
			foreach ($apartments as $apartment) {
				$images_indexes = [];
				do {
					$index = rand(0, count($imageNames) - 1);
					if (!in_array($index, $images_indexes) && $imageNames[$index] != $apartment->main_image) {
						$images_indexes[] = $index;
					}
				} while (count($images_indexes) < $images_per_apartment);
				$i = 1;
				foreach ($images_indexes as $images_index) {
					Image::create(
					  [
						'apartment_id' => $apartment->id,
						'name' => $imageNames[$images_index],
						'index' => $i++
					  ]
					);
				}
			}
		}
	}
