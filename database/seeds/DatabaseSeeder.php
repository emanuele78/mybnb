<?php
	
	use Illuminate\Database\Seeder;
	
	class DatabaseSeeder extends Seeder {
		
		/**
		 * Seed the application's database.
		 *
		 * @return void
		 */
		public function run() {
			
			$this->call(UsersTableSeeder::class);
			$this->call(CustomersTableSeeder::class);
			$this->call(ApartmentsTableSeeder::class);
			$this->call(PromotionPlansTableSeeder::class);
			$this->call(PromotionsTableSeeder::class);
			$this->call(ImagesTableSeeder::class);
			$this->call(TokensTableSeeder::class);
			$this->call(ServicesTableSeeder::class);
			$this->call(UpgradesTableSeeder::class);
			$this->call(ReservedDaysTableSeeder::class);
			if (config('project.use_debug_mode_when_seeding')) {
				$this->call(BookingsTableSeeder::class);
				$this->call(ThreadsTableSeeder::class);
				$this->call(MessagesTableSeeder::class);
				$this->call(BookedServicesTableSeeder::class);
			}
			//production demo seeder
			$this->call(DemoSeeder::class);
		}
	}
