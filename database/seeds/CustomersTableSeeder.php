<?php
	
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class CustomersTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 */
		public function run() {
			
			$faker = Faker\Factory::create('it_IT');
			//every user is already a fake (not registered in braintree account) customer
			$users = User::get();
			$now = Carbon::now();
			foreach ($users as $user) {
				DB::table('customers')->insert(
				  [
					'user_id' => $user->id,
					'customer_id' => $user->id,
					'firstName' => $faker->firstName,
					'lastName' => $faker->lastName,
					'taxCode' => $faker->taxId(),
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
