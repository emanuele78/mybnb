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
			
			$imageNames = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.jpg', 'image6.jpg', 'image7.jpg', 'image8.jpg', 'image9.jpg', 'image10.jpg'];
			$apartments = Apartment::get();
			foreach ($apartments as $apartment) {
				Image::create(
				  [
					'apartment_id' => $apartment->id,
					'name' => $imageNames[rand(0, count($imageNames) - 1)],
				  ]);
			}
		}
	}
