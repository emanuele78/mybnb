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
				$index = 1;
				shuffle($imageNames);
				for ($i = 0; $i < $images_per_apartment; $i++) {
					Image::create(
					  [
						'apartment_id' => $apartment->id,
						'name' => $imageNames[$i],
						'index' => $index++
					  ]
					);
				}
			}
		}
	}
