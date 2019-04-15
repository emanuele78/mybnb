<?php
	
	use App\Apartment;
	use App\Booking;
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class BookingsTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$apartments = Apartment::get();
			$users = User::get();
			$check_in = Carbon::now()->addDays(14);
			$check_out = Carbon::now()->addDays(20);
			foreach ($apartments as $apartment) {
				$random_user = $users[rand(0, $users->count() - 1)];
				Booking::create(
				  [
					'user_id' => $random_user->id,
					'apartment_id' => $apartment->id,
					'apartment_title' => $apartment->title,
					'user_nickname' => $random_user->nickname,
					'check_in' => $check_in,
					'check_out' => $check_out,
					'special_requests' => 'In attesa Vs istruzioni per il ritiro della chiave. Grazie',
					'apartment_amount' => $apartment->price_per_night * $check_out->diffInDays($check_in)
				  ]);
			}
			
		}
	}
