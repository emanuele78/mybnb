<?php
	
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class TokensTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			if (config('project.add_debug_token')) {
				//just for testing purposes
				DB::table('tokens')->insert(
				  [
					'token_code' => config('project.token_debug_code'),
					'email' => 'debug@debug.dev',
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				  ]);
			}
		}
	}
