<?php
	
	use App\Booking;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class BookedServicesTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$now = Carbon::now();
			$bookings = Booking::get();
			foreach ($bookings as $booking) {
				//every booking has 2 services upgrades
				$current_booked_apartment_available_upgrades = $booking->apartment->upgrades;
				$pricedServicesCollection = $current_booked_apartment_available_upgrades->where('price_per_night', '>', 0)->random(2);
				$first_upgrade = $pricedServicesCollection->first();
				$second_upgrade = $pricedServicesCollection->last();
				DB::table('booked_services')->insert(
				  [
					[
					  'booking_id' => $booking->id,
					  'name' => $first_upgrade->service->name,
					  'price_per_night' => $first_upgrade->price_per_night,
					  'created_at' => $now,
					  'updated_at' => $now,
					],
					[
					  'booking_id' => $booking->id,
					  'name' => $second_upgrade->service->name,
					  'price_per_night' => $second_upgrade->price_per_night,
					  'created_at' => $now,
					  'updated_at' => $now,
					],
				  ]
				);
			}
		}
	}
