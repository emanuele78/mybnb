<?php
	
	use App\Apartment;
	use App\User;
	use Illuminate\Database\Seeder;
	use Faker\Generator as Faker;
	
	class ApartmentsTableSeeder extends Seeder {
		
		private $users;
		
		/**
		 * @param Faker $faker
		 */
		public function run(Faker $faker) {
			
			$this->users = User::all();
			$rawData = Config::get('cities');
			$apartmentsPerAxis = config('project.apartments_per_axys');
			$kmToAdd = 5;
			for ($i = 0; $i < count($rawData); $i++) {
				//inserisco appartamento nella città
				$lat = $rawData[$i]['lat'];
				$lng = $rawData[$i]['lng'];
				$cityApartment = $this->getRandomData($faker, $lat, $lng);
				Apartment::create($cityApartment);
				//generate $apartmentsPerAxis to North
				for ($k = 0; $k < $apartmentsPerAxis; $k++) {
					$lat = $this->getNewLatitude($lat, $kmToAdd);
					$newApartment = $this->getRandomData($faker, $lat, $lng);
					Apartment::create($newApartment);
				}
				//generate $apartmentsPerAxis to South
				$lat = $cityApartment['latitude'];
				for ($k = 0; $k < $apartmentsPerAxis; $k++) {
					$lat = $this->getNewLatitude($lat, -$kmToAdd);
					$newApartment = $this->getRandomData($faker, $lat, $lng);
					Apartment::create($newApartment);
				}
				//generate $apartmentsPerAxis to East
				$lat = $cityApartment['latitude'];
				for ($k = 0; $k < $apartmentsPerAxis; $k++) {
					$lng = $this->getNewLongitude($lat, $lng, $kmToAdd);
					$newApartment = $this->getRandomData($faker, $lat, $lng);
					Apartment::create($newApartment);
				}
				//generate $apartmentsPerAxis to West
				$lng = $cityApartment['longitude'];
				for ($k = 0; $k < $apartmentsPerAxis; $k++) {
					$lng = $this->getNewLongitude($lat, $lng, -$kmToAdd);
					$newApartment = $this->getRandomData($faker, $lat, $lng);
					Apartment::create($newApartment);
				}
			}
		}
		
		private function getRandomData(Faker $faker, $lat, $lng) {
			
			$imageNames = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.jpg', 'image6.jpg', 'image7.jpg', 'image8.jpg', 'image9.jpg', 'image10.jpg'];
			
			return [
			  'user_id' => $this->users[rand(0, count($this->users) - 1)]->id,
			  'title' => $faker->text(rand(50, 100)),
			  'main_image' => $imageNames[rand(0, count($imageNames) - 1)],
			  'description' => $faker->text(1250),
			  'room_count' => rand(3, 6),
			  'people_count' => rand(3, 6),
			  'bathroom_count' => rand(1, 3),
			  'square_meters' => rand(50, 150),
			  'price_per_night' => rand(10, 150),
			  'sale' => (rand(1, 4) === rand(1, 4) ? rand(10, 50) : 0),
			  'max_stay' => rand(7, 30),
			  'latitude' => $lat,
			  'longitude' => $lng
			];
		}
		
		private function getNewLatitude($latitude, $kmToAdd) {
			
			$decimal_round = 7;
			return round($latitude + ($kmToAdd / 6372) * (180 / pi()), $decimal_round);
		}
		
		private function getNewLongitude($latitude, $longitude, $kmToAdd) {
			
			$decimal_round = 7;
			return round($longitude + ($kmToAdd / 6372) * (180 / pi()) / cos($latitude * pi() / 180), $decimal_round);
		}
	}
