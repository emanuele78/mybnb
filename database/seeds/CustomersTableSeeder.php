<?php
	
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Faker\Generator as Faker;
	
	class CustomersTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @param Faker $faker
		 */
		public function run(Faker $faker) {
			
			$users = User::get();
			$now = Carbon::now();
			foreach ($users as $user) {
				DB::table('customers')->insert(
				  [
					'user_id' => $user->id,
					'customer_id' => $user->id,
					'firstName' => $faker->firstName,
					'lastName' => $faker->lastName,
					'streetAddress' => 'via Gargantua 14',
					'locality' => 'Gargantua',
					'postalCode' => 12345,
					'created_at' => $now,
					'updated_at' => $now,
				  ]
				);
			}
		}
	}
