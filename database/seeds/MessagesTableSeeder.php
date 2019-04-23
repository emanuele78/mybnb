<?php
	
	use App\Thread;
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
			$threads = Thread::get();
			foreach ($threads as $thread) {
				DB::table('messages')->insert(
				  [
					[
					  'thread_id' => $thread->id,
						''
					]
				  ]
				);
				
			}
		}
	}
