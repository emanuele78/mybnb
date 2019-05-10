<?php
	
	use App\Apartment;
	use App\Booking;
	use App\Thread;
	use App\PromotionPlan;
	use App\Service;
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	
	class DemoSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$user = $this->createDemoUser();
			$apartment = $this->createApartmentsForDemoUser($user);
			$this->promoteApartment($apartment);
			$this->addServices($apartment);
			$this->reserveDays($apartment);
			$this->addOtherImages($apartment);
			$this->whoWannaBeACustomerUser($user);
			$this->madeABooking($user);
			$this->receiveABooking($apartment);
		}
		
		/**
		 * Create a demo user
		 *
		 * @return User
		 */
		private function createDemoUser(): User {
			
			$user = new User();
			$user->fill(
			  [
				'email' => 'demo@gmail.com',
				'password' => bcrypt('secret'),
				'nickname' => 'Demouser',
				'date_of_birth' => Carbon::createFromFormat('d-m-Y', '09-01-1978'),
			  ]);
			$user->save();
			return $user;
		}
		
		/**
		 * Create an apartment demo user wants to rent
		 *
		 * @param User $user
		 * @return Apartment
		 */
		private function createApartmentsForDemoUser(User $user): Apartment {
			
			$apartment = new Apartment();
			$apartment->fill(
			  [
				'user_id' => $user->id,
				'title' => 'Fantastico appartamento a Monte San Giusto',
				'main_image' => 'image1.jpg',
				'description' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',
				'room_count' => rand(3, 6),
				'people_count' => rand(3, 6),
				'bathroom_count' => rand(1, 3),
				'square_meters' => rand(50, 150),
				'price_per_night' => rand(10, 150),
				'sale' => (rand(1, 4) === rand(1, 4) ? rand(10, 50) : 0),
				'max_stay' => rand(7, 30),
				'latitude' => 43.231260,
				'longitude' => 13.594569
			  ]
			);
			$apartment->save();
			return $apartment;
		}
		
		/**
		 * Promote the apartment
		 *
		 * @param Apartment $apartment
		 */
		private function promoteApartment(Apartment $apartment): void {
			
			DB::table('promotions')->insert(
			  [
				'apartment_id' => $apartment->id,
				'reference' => Str::uuid(),
				'promotion_plan_id' => PromotionPlan::get()->first()->id,
				'start_at' => Carbon::now(),
				'end_at' => Carbon::now()->addDays(3),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			  ]
			);
		}
		
		/**
		 * Add services to demo apartment
		 *
		 * @param Apartment $apartment
		 */
		private function addServices(Apartment $apartment): void {
			
			$services = Service::take(8)->get();
			foreach ($services as $key => $service) {
				
				DB::table('upgrades')->insert(
				  [
					'apartment_id' => $apartment->id,
					'service_id' => $service->id,
					'price_per_night' => $key < 4 ? rand(5, 10) : 0,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				  ]);
			}
		}
		
		/**
		 * Reserve days to demo apartment
		 *
		 * @param Apartment $apartment
		 */
		private function reserveDays(Apartment $apartment): void {
			
			$first_day_reserved = Carbon::now()->addDays(3);
			$second_day_reserved = Carbon::now()->addDays(6);
			$third_day_reserved = Carbon::now()->addDays(9);
			DB::table('reserved_days')->insert(
			  [
				[
				  'day' => $first_day_reserved,
				  'apartment_id' => $apartment->id
				],
				[
				  'day' => $second_day_reserved,
				  'apartment_id' => $apartment->id
				],
				[
				  'day' => $third_day_reserved,
				  'apartment_id' => $apartment->id
				]
			  ]
			);
		}
		
		/**
		 * Add other images to demo apartment
		 *
		 * @param Apartment $apartment
		 */
		private function addOtherImages(Apartment $apartment): void {
			
			DB::table('images')->insert(
			  [
				[
				  'apartment_id' => $apartment->id,
				  'name' => 'image2.jpg',
				  'index' => 1
				],
				[
				  'apartment_id' => $apartment->id,
				  'name' => 'image3.jpg',
				  'index' => 2
				],
				[
				  'apartment_id' => $apartment->id,
				  'name' => 'image4.jpg',
				  'index' => 3
				]
			  ]
			);
		}
		
		/**
		 * Let user be a customer
		 *
		 * @param User $user
		 */
		public function whoWannaBeACustomerUser(User $user): void {
			
			DB::table('customers')->insert(
			  [
				'user_id' => $user->id,
				'customer_id' => config('project.demo_customer_id'),
				'firstName' => 'Mario',
				'lastName' => 'Rossi',
				'streetAddress' => 'via XI Settembre 2001, n. 6',
				'locality' => 'Monte San Giusto',
				'postalCode' => 62015,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			  ]
			);
		}
		
		/**
		 * Demo user book another apartment
		 *
		 * @param User $user
		 */
		public function madeABooking(User $user): void {
			
			$apartmentBooked = Apartment::first();
			$booking = new Booking();
			$booking->fill(
			  [
				'reference' => (string)Str::uuid(),
				'status' => 'confirmed',
				
				'user_booking_id' => $user->id,
				'user_booking_nickname' => $user->nickname,
				'user_booking_fullname' => $user->fullname(),
				'user_booking_address' => $user->customer->streetAddress,
				'user_booking_full_locality' => $user->fullLocality(),
				'user_booking_email' => $user->email,
				
				'apartment_id' => $apartmentBooked->id,
				'apartment_slug' => $apartmentBooked->slug,
				'apartment_title' => $apartmentBooked->title,
				'apartment_owner_id' => $apartmentBooked->owner()->id,
				'apartment_owner_nickname' => $apartmentBooked->owner()->nickname,
				'apartment_owner_fullname' => $apartmentBooked->owner()->fullname(),
				'apartment_owner_address' => $apartmentBooked->owner()->customer->streetAddress,
				'apartment_owner_full_locality' => $apartmentBooked->owner()->fullLocality(),
				'apartment_owner_email' => $apartmentBooked->owner()->email,
				'apartment_image' => $apartmentBooked->main_image,
				
				'check_in' => Carbon::now()->addDays(-10),
				'check_out' => Carbon::now()->addDays(-5),
				'special_requests' => 'Non vedo l\'ora di arrivare al vostro appartamento',
				'apartment_price_per_night' => $apartmentBooked->calcCurrentPrice(),
				'updated_at' => Carbon::now()->addDays(-12),
				'created_at' => Carbon::now()->addDays(-12),
			  ]
			);
			$booking->save();
			$this->bookServices($booking, $apartmentBooked);
			$this->threadForDemo($apartmentBooked, $user);
		}
		
		/**
		 * Add upgrades to a booking
		 *
		 * @param Booking $booking
		 * @param Apartment $bookedApartment
		 */
		private function bookServices(Booking $booking, Apartment $bookedApartment): void {
			
			foreach ($bookedApartment->upgrades as $upgrade) {
				DB::table('booked_services')->insert(
				  [
					'booking_id' => $booking->id,
					'name' => $upgrade->service->name,
					'slug' => $upgrade->service->slug,
					'price_per_night' => $upgrade->price_per_night,
					'created_at' => $booking->created_at,
					'updated_at' => $booking->created_at,
				  ]
				);
			}
		}
		
		private function threadForDemo(Apartment $apartmentBooked, User $userBooking): void {
			
			$thread = new Thread();
			$thread->fill(
			  [
				'reference_id' => (string)Str::uuid(),
				'apartment_id' => $apartmentBooked->id,
				'apartment_owner_nickname' => $apartmentBooked->owner()->nickname,
				'apartment_title' => $apartmentBooked->title,
				'with_user_id' => $userBooking->id,
				'updated_at' => Carbon::now()->addDays(-30),
				'created_at' => Carbon::now()->addDays(-30),
			  ]
			);
			$thread->save();
			
			//adding messages
			DB::table('messages')->insert(
			  [
				[
				  'thread_id' => $thread->id,
				  'sender_id' => $userBooking->id,
				  'recipient_id' => $apartmentBooked->owner()->id,
				  'visible_for' => null,
				  'body' => 'Ciao, questo appartamento proprio mi piace! La zona è tranquilla?',
				  'unread' => 0,
				  'created_at' => Carbon::now()->addDays(-40),
				  'updated_at' => Carbon::now()->addDays(-40)
				],
				[
				  'thread_id' => $thread->id,
				  'sender_id' => $apartmentBooked->owner()->id,
				  'recipient_id' => $userBooking->id,
				  'visible_for' => null,
				  'body' => 'Ciao, sono molto contento che ti piace. Si, la zona è veramente tranquilla!',
				  'unread' => 0,
				  'created_at' => Carbon::now()->addDays(-39),
				  'updated_at' => Carbon::now()->addDays(-39)
				],
				[
				  'thread_id' => $thread->id,
				  'sender_id' => $userBooking->id,
				  'recipient_id' => $apartmentBooked->owner()->id,
				  'visible_for' => null,
				  'body' => 'Ok perfetto, allora tra non molto farò la prenotazione, grazie!',
				  'unread' => 0,
				  'created_at' => Carbon::now()->addDays(-38),
				  'updated_at' => Carbon::now()->addDays(-38)
				],
				[
				  'thread_id' => $thread->id,
				  'sender_id' => $apartmentBooked->owner()->id,
				  'recipient_id' => $userBooking->id,
				  'visible_for' => null,
				  'body' => 'Ti ringrazio, se serve altro sono a tua disposizione!',
				  'unread' => 0,
				  'created_at' => Carbon::now()->addDays(-37),
				  'updated_at' => Carbon::now()->addDays(-37)
				],
				[
				  'thread_id' => $thread->id,
				  'sender_id' => $apartmentBooked->owner()->id,
				  'recipient_id' => $userBooking->id,
				  'visible_for' => null,
				  'body' => 'Ehi ho visto che anche tu hai messo un appartamento nel sito, complimenti!',
				  'unread' => 1,
				  'created_at' => Carbon::now()->addDays(-1),
				  'updated_at' => Carbon::now()->addDays(-1)
				],
			  ]
			);
		}
		
		/**
		 * Demo apartment receives its first booking
		 *
		 * @param Apartment $demoApartment
		 */
		private function receiveABooking(Apartment $demoApartment): void {
			
			$otherUser = User::first();
			$booking = new Booking();
			$booking->fill(
			  [
				'reference' => (string)Str::uuid(),
				'status' => 'confirmed',
				
				'user_booking_id' => $otherUser->id,
				'user_booking_nickname' => $otherUser->nickname,
				'user_booking_fullname' => $otherUser->fullname(),
				'user_booking_address' => $otherUser->customer->streetAddress,
				'user_booking_full_locality' => $otherUser->fullLocality(),
				'user_booking_email' => $otherUser->email,
				
				'apartment_id' => $demoApartment->id,
				'apartment_slug' => $demoApartment->slug,
				'apartment_title' => $demoApartment->title,
				'apartment_owner_id' => $demoApartment->owner()->id,
				'apartment_owner_nickname' => $demoApartment->owner()->nickname,
				'apartment_owner_fullname' => $demoApartment->owner()->fullname(),
				'apartment_owner_address' => $demoApartment->owner()->customer->streetAddress,
				'apartment_owner_full_locality' => $demoApartment->owner()->fullLocality(),
				'apartment_owner_email' => $demoApartment->owner()->email,
				'apartment_image' => $demoApartment->main_image,
				
				'check_in' => Carbon::now()->addDays(-20),
				'check_out' => Carbon::now()->addDays(-10),
				'special_requests' => 'Sono molto felice di venire a Monte San Giusto',
				'apartment_price_per_night' => $demoApartment->calcCurrentPrice(),
				'updated_at' => Carbon::now()->addDays(-22),
				'created_at' => Carbon::now()->addDays(-22),
			  ]
			);
			$booking->save();
			$this->bookServices($booking, $demoApartment);
		}
	}
