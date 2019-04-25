<?php
	
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Faker\Generator as Faker;
	
	class UsersTableSeeder extends Seeder {
		
		public function run(Faker $faker) {
			
			$birthday = Carbon::now()->addYears(-25);
			$now = Carbon::now();
			$user_count = 10;
			for ($i = 0; $i < $user_count; $i++) {
				DB::table('users')->insert(
				  [
					'email' => $faker->unique()->email,
					'password' => bcrypt('secret'),
					'nickname' => $faker->unique()->firstName,
					'date_of_birth' => $birthday,
					'created_at' => $now,
					'updated_at' => $now,
				  ]);
			}
		}
	}
