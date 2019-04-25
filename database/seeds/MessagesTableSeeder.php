<?php
	
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class MessagesTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$first_date = Carbon::now()->addDays(-1);
			$second_date = Carbon::now()->addHours(-12);
			$users = User::get();
			foreach ($users as $user) {
				//get a random users
				do {
					$random_first_user_index = rand(0, count($users) - 1);
				} while ($users[$random_first_user_index]->id == $user->id);
				$other_user = $users[$random_first_user_index];
				$current_user_apartment = $user->apartments()->first();
				$other_user_apartment = $other_user->apartments()->first();
				//generate request/response messages
				DB::table('messages')->insert(
				  [
					[
					  'apartment_id' => $current_user_apartment->id,
					  'sender_id' => $other_user->id,
					  'recipient_id' => $user->id,
					  'body' => 'Buongiorno ' . $user->nickname . ', mi daresti maggiori informazioni su questo appartamento?',
					  'unreaded' => 0,
					  'created_at' => $first_date,
					  'updated_at' => $first_date
					],
					[
					  'apartment_id' => $current_user_apartment->id,
					  'sender_id' => $user->id,
					  'recipient_id' => $other_user->id,
					  'body' => 'Buongiorno ' . $other_user->nickname . ', certo, è un bellissim appartamento. Chiedimi quello che vuoi',
					  'unreaded' => 0,
					  'created_at' => $second_date,
					  'updated_at' => $second_date
					],
					[
					  'apartment_id' => $other_user_apartment->id,
					  'sender_id' => $user->id,
					  'recipient_id' => $other_user->id,
					  'body' => 'Ciao ' . $other_user->nickname . ', è disponibile il tuo appartamento',
					  'unreaded' => 0,
					  'created_at' => $first_date,
					  'updated_at' => $first_date
					],
					[
					  'apartment_id' => $other_user_apartment->id,
					  'sender_id' => $other_user->id,
					  'recipient_id' => $user->id,
					  'body' => 'Ciao ' . $user->nickname . ', al momento no',
					  'unreaded' => 0,
					  'created_at' => $second_date,
					  'updated_at' => $second_date
					],
				  ]
				);
			}
		}
	}
