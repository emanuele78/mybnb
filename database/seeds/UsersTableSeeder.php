<?php
	
	use App\User;
	use Illuminate\Database\Seeder;
	use Faker\Generator as Faker;
	
	class UsersTableSeeder extends Seeder {
		
		public function run(Faker $faker) {
			$user_count = 10;
			for ($i = 0; $i < $user_count; $i++) {
				User::create(
				  [
					'email' => $faker->unique()->email,
					'password' => bcrypt('secret'),
					'nickname' => $faker->firstName,
				  ]);
			}
			//adding one site admin
			User::create(
			  [
				'email' => $faker->unique()->email,
				'password' => bcrypt('admin'),
				'nickname' => $faker->firstName,
				'is_admin' => 1,
			  ]);
		}
	}
