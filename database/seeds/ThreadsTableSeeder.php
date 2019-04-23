<?php
	
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class ThreadsTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$users = User::get();
			foreach ($users as $user) {
				//get two random users
				do {
					$random_first_user_index = rand(0, count($users) - 1);
				} while ($users[$random_first_user_index]->id == $user->id);
				$first_user = $users[$random_first_user_index];
				do {
					$random_second_user_index = rand(0, count($users) - 1);
				} while ($users[$random_first_user_index]->id == $user->id || $users[$random_first_user_index]->id == $random_second_user_index);
				$second_user = $users[$random_second_user_index];
				//get two random current user apartments
				$current_user_first_apartment = $user->apartments()->first();
				$current_user_second_apartment = $user->apartments()->orderBy('id', 'desc')->first();
				//generate threads for received requests
				DB::table('threads')->insert(
				  [
					[
					  'started_by' => $first_user->id,
					  'apartment_id' => $current_user_first_apartment->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
					[
					  'started_by' => $first_user->id,
					  'apartment_id' => $current_user_second_apartment->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
					[
					  'started_by' => $second_user->id,
					  'apartment_id' => $current_user_first_apartment->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
					[
					  'started_by' => $second_user->id,
					  'apartment_id' => $current_user_second_apartment->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
				  ]
				);
				//generate threads started by current user
				DB::table('threads')->insert(
				  [
					[
					  'started_by' => $user->id,
					  'apartment_id' => $first_user->apartments()->first()->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
					[
					  'started_by' => $user->id,
					  'apartment_id' => $first_user->apartments()->orderBy('id', 'desc')->first()->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
					[
					  'started_by' => $user->id,
					  'apartment_id' => $second_user->apartments()->first()->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
					[
					  'started_by' => $user->id,
					  'apartment_id' => $second_user->apartments()->orderBy('id', 'desc')->first()->id,
					  'created_at' => Carbon::now(),
					  'updated_at' => Carbon::now()
					],
				  ]
				);
			}
		}
	}
