<?php
	
	use Illuminate\Database\Seeder;
	
	class TokensTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			DB::table('tokens')->insert(
			  [
				'token_code' => config('project.token_debug_code'),
				'email' => 'debug@debug.dev'
			  ]);
		}
	}
