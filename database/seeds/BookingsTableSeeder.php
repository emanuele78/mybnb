<?php
	
	use App\Apartment;
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	
	class BookingsTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$users = User::get();
			$passed_days = 220;
			//every user books two apartments from two other random distinct users, twice
			foreach ($users as $user) {
				do {
					$first_owner_index = rand(0, count($users) - 1);
				} while ($users[$first_owner_index]->id == $user->id);
				$first_apartment_owner = $users[$first_owner_index];
				$first_apartment_booked = $first_apartment_owner->apartments()->first();
				do {
					$second_owner_index = rand(0, count($users) - 1);
				} while ($users[$second_owner_index]->id == $user->id || $second_owner_index == $first_owner_index);
				$second_apartment_owner = $users[$second_owner_index];
				$second_apartment_booked = $second_apartment_owner->apartments()->first();
				DB::table('bookings')->insert(
				  [
					$this->getArrayData($user, $first_apartment_booked, $passed_days),
					$this->getArrayData($user, $second_apartment_booked, $passed_days),
					$this->getArrayData($user, $first_apartment_booked, $passed_days),
					$this->getArrayData($user, $second_apartment_booked, $passed_days, true),
				  ]
				);
			}
			//now every user has two distinct apartments each one booked by distinct user
			foreach ($users as $user) {
				$first_current_user_apartment = $user->apartments->first();
				$second_current_user_apartment = $user->apartments->last();
				do {
					$first_booking_user_index = rand(0, count($users) - 1);
				} while ($users[$first_booking_user_index]->id == $user->id);
				do {
					$second_booking_user_index = rand(0, count($users) - 1);
				} while ($users[$second_booking_user_index]->id == $user->id || $second_booking_user_index == $first_booking_user_index);
				DB::table('bookings')->insert(
				  [
					$this->getArrayData($users[$first_booking_user_index], $first_current_user_apartment, $passed_days),
					$this->getArrayData($users[$second_booking_user_index], $first_current_user_apartment, $passed_days),
					$this->getArrayData($users[$first_booking_user_index], $second_current_user_apartment, $passed_days),
					$this->getArrayData($users[$second_booking_user_index], $second_current_user_apartment, $passed_days),
				  ]
				);
			}
			//now each apartment has a two future bookings, the first from one month from now
			//the secondo from 35 days from now - user booking is not important for this testing
			$apartments = Apartment::get();
			$userBooking = $users->first();
			$futureFirstBookingStart = Carbon::now()->addDays(30);
			$futureFirstBookingEnd = Carbon::now()->addDays(30 + 2);
			$futureSecondBookingStart = Carbon::now()->addDays(35);
			$futureSecondBookingEnd = Carbon::now()->addDays(35 + 2);
			foreach ($apartments as $apartment) {
				DB::table('bookings')->insert(
				  [
					$this->getData($userBooking, $apartment, $futureFirstBookingStart, $futureFirstBookingEnd),
					$this->getData($userBooking, $apartment, $futureSecondBookingStart, $futureSecondBookingEnd),
				  ]
				);
			}
		}
		
		private function getArrayData(User $userBooking, Apartment $bookedApartment, int &$passed_days, $pending = false, $nights_to_stay = 2) {
			
			$check_in = Carbon::now()->addDays(-$passed_days);
			$check_out = Carbon::now()->addDays(-($passed_days = $passed_days - $nights_to_stay));
			return $this->getData($userBooking, $bookedApartment, $check_in, $check_out, $pending);
		}
		
		private function getData(User $userBooking, Apartment $bookedApartment, $check_in, $check_out, $pending = false) {
			
			$now = Carbon::now();
			return [
			  'reference' => (string)Str::uuid(),
			  'status' => $pending ? 'pending' : 'confirmed',
			  
			  'user_booking_id' => $userBooking->id,
			  'user_booking_nickname' => $userBooking->nickname,
			  'user_booking_fullname' => $userBooking->fullname(),
			  'user_booking_address' => $userBooking->customer->streetAddress,
			  'user_booking_full_locality' => $userBooking->fullLocality(),
			  'user_booking_email' => $userBooking->email,
			  
			  'apartment_id' => $bookedApartment->id,
			  'apartment_slug' => $bookedApartment->slug,
			  'apartment_title' => $bookedApartment->title,
			  'apartment_owner_id' => $bookedApartment->user->id,
			  'apartment_owner_nickname' => $bookedApartment->user->nickname,
			  'apartment_owner_fullname' => $bookedApartment->user->fullname(),
			  'apartment_owner_address' => $bookedApartment->user->customer->streetAddress,
			  'apartment_owner_full_locality' => $bookedApartment->user->fullLocality(),
			  'apartment_owner_email' => $bookedApartment->user->email,
			  'apartment_image' => $bookedApartment->main_image,
			  
			  'check_in' => $check_in,
			  'check_out' => $check_out,
			  'special_requests' => 'In attesa Vs istruzioni per il ritiro della chiave. Grazie',
			  'apartment_price_per_night' => $bookedApartment->calcCurrentPrice(),
			  'created_at' => $now,
			  'updated_at' => $now,
			];
		}
	}
