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
			
			$first_message_date = Carbon::now()->addDays(-1);
			$second_message_date = Carbon::now()->addHours(-10);
			$users = User::get();
			foreach ($users as $user) {
				//generate two apartment_threads for the current user
				$current_user_first_apartment = $user->apartments()->first();
				$current_user_second_apartment = $user->apartments()->orderBy('id', 'desc')->first();
				//generate two random other users
				do {
					$random_first_user_index = rand(0, count($users) - 1);
				} while ($users[$random_first_user_index]->id == $user->id);
				$first_user = $users[$random_first_user_index];
				do {
					$random_second_user_index = rand(0, count($users) - 1);
				} while ($users[$random_first_user_index]->id == $user->id || $users[$random_first_user_index]->id == $random_second_user_index);
				$second_user = $users[$random_second_user_index];
				//1) generate 2 fake threads for 2 distinct apartments owned by the current user
				//each thread has request and response message
				DB::table('messages')->insert(
				  [
					  //first apartment received message
					[
					  'apartment_id' => $current_user_first_apartment->id,
					  'sender_user_id' => $first_user->id,
					  'recipient_user_id' => $user->id,
					  'body' => 'Ciao, vorrei chiederti maggiori informazioni su questo appartamento',
					  'unreaded' => 0,
					  'created_at' => $first_message_date,
					  'updated_at' => $first_message_date,
					],
					  //first apartment response
					[
					  'apartment_id' => $current_user_first_apartment->id,
					  'sender_user_id' => $user->id,
					  'recipient_user_id' => $first_user->id,
					  'body' => 'Ciao, con piacere, chiedimi pure tutto quello che vuoi',
					  'unreaded' => 0,
					  'created_at' => $second_message_date,
					  'updated_at' => $second_message_date,
					],
					  //second apartment received message
					[
					  'apartment_id' => $current_user_second_apartment->id,
					  'sender_user_id' => $second_user->id,
					  'recipient_user_id' => $user->id,
					  'body' => 'Ciao, questo appartamento mi piace',
					  'unreaded' => 0,
					  'created_at' => $first_message_date,
					  'updated_at' => $first_message_date,
					],
					  //second apartment response
					[
					  'apartment_id' => $current_user_second_apartment->id,
					  'sender_user_id' => $user->id,
					  'recipient_user_id' => $second_user->id,
					  'body' => 'Ciao, sono contento ti piaccia, spero ci verrai a trovare',
					  'unreaded' => 0,
					  'created_at' => $second_message_date,
					  'updated_at' => $second_message_date,
					]
				  ]);
				//2) generate 2 fake threads for 2 distincts apartment of which current user are interested in
				$first_user_apartment = $first_user->apartments()->first();
				$second_user_apartment = $second_user->apartments()->first();
				DB::table('messages')->insert(
				  [
					  //first apartment message sent
					[
					  'apartment_id' => $first_user_apartment->id,
					  'sender_user_id' => $user->id,
					  'recipient_user_id' => $first_user->id,
					  'body' => 'Ciao, di quanti metri è questo appartamento',
					  'unreaded' => 0,
					  'created_at' => $first_message_date,
					  'updated_at' => $first_message_date,
					],
					  //first apartment response
					[
					  'apartment_id' => $first_user_apartment->id,
					  'sender_user_id' => $first_user->id,
					  'recipient_user_id' => $user->id,
					  'body' => 'Ciao, aspetta controllo poi ti dico',
					  'unreaded' => 0,
					  'created_at' => $second_message_date,
					  'updated_at' => $second_message_date,
					],
					  //second apartment message sent
					[
					  'apartment_id' => $second_user_apartment->id,
					  'sender_user_id' => $user->id,
					  'recipient_user_id' => $second_user->id,
					  'body' => 'Ciao, è possibile avere il servizio in camera',
					  'unreaded' => 0,
					  'created_at' => $first_message_date,
					  'updated_at' => $first_message_date,
					],
					  //second apartment response
					[
					  'apartment_id' => $second_user_apartment->id,
					  'sender_user_id' => $second_user->id,
					  'recipient_user_id' => $user->id,
					  'body' => 'Ciao, certamente senza alcun problema',
					  'unreaded' => 0,
					  'created_at' => $second_message_date,
					  'updated_at' => $second_message_date,
					]
				  ]);
				
			}
		}
	}
