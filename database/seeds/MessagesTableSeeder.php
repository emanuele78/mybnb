<?php
	
	use App\User;
	use App\Thread;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class MessagesTableSeeder extends Seeder {
		
		/**
		 * @throws Exception
		 */
		public function run() {
			
			$first_date = Carbon::now()->addDays(-1);
			$second_date = Carbon::now()->addHours(-16);
			$third_date = Carbon::now()->addHours(-8);
			$fourth_date = Carbon::now();
			
			$firstUser = User::find(1);
			$secondUser = User::find(2);
			$thirdUser = User::find(3);
			
			$threads = Thread::orderBy('id', 'asc')->get();
			foreach ($threads as $thread) {
				switch ($thread->id) {
					case 1:
						$this->insert($thread, $firstUser, $secondUser, $first_date);
						$this->insert($thread, $firstUser, $secondUser, $second_date);
						$this->insert($thread, $secondUser, $firstUser, $third_date);
						$this->insert($thread, $secondUser, $firstUser, $fourth_date);
						break;
					case 2:
						$this->insert($thread, $thirdUser, $secondUser, $first_date);
						$this->insert($thread, $thirdUser, $secondUser, $second_date);
						$this->insert($thread, $secondUser, $thirdUser, $third_date);
						$this->insert($thread, $secondUser, $thirdUser, $fourth_date);
						break;
					case 3:
						$this->insert($thread, $thirdUser, $secondUser, $first_date);
						$this->insert($thread, $thirdUser, $secondUser, $second_date);
						$this->insert($thread, $secondUser, $thirdUser, $third_date);
						$this->insert($thread, $secondUser, $thirdUser, $fourth_date);
						break;
					case 4:
						$this->insert($thread, $secondUser, $firstUser, $first_date);
						$this->insert($thread, $secondUser, $firstUser, $second_date);
						$this->insert($thread, $firstUser, $secondUser, $third_date);
						$this->insert($thread, $firstUser, $secondUser, $fourth_date);
						break;
					default:
						throw new Exception('wrong thread id');
				}
			}
			
		}
		
		private function insert($thread, $sender, $recipient, $date) {
			
			DB::table('messages')->insert(
			  [
				'thread_id' => $thread->id,
				'sender_id' => $sender->id,
				'recipient_id' => $recipient->id,
				'visible_for' => null,
				'body' => 'Ciao ' . $recipient->nickname . ', sono ' . $sender->nickname . '. Questo è il thread n.' . $thread->id,
				'unread' => 1,
				'created_at' => $date,
				'updated_at' => $date
			  ]
			);
		}
	}
