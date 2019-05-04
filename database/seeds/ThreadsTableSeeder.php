<?php
	
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	
	class ThreadsTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$firstUser = User::find(1);
			$secondUser = User::find(2);
			$thirdUser = User::find(3);
			$firstUserApartment = $firstUser->apartments()->first();
			$secondUserFirstApartment = $secondUser->apartments()->first();
			$secondUserSecondApartment = $secondUser->apartments()->orderBy('id', 'desc')->first();
			DB::table('threads')->insert(
			  [
				[
				  'reference_id' => (string)Str::uuid(),
				  'apartment_id' => $secondUserFirstApartment->id,
				  'apartment_owner_nickname' => $secondUserFirstApartment->owner()->nickname,
				  'apartment_title' => $secondUserFirstApartment->title,
				  'with_user_id' => $firstUser->id,
				  'created_at' => Carbon::now(),
				  'updated_at' => Carbon::now(),
				],
				[
				  'reference_id' => (string)Str::uuid(),
				  'apartment_id' => $secondUserFirstApartment->id,
				  'apartment_owner_nickname' => $secondUserFirstApartment->owner()->nickname,
				  'apartment_title' => $secondUserFirstApartment->title,
				  'with_user_id' => $thirdUser->id,
				  'created_at' => Carbon::now(),
				  'updated_at' => Carbon::now(),
				],
				[
				  'reference_id' => (string)Str::uuid(),
				  'apartment_id' => $secondUserSecondApartment->id,
				  'apartment_owner_nickname' => $secondUserSecondApartment->owner()->nickname,
				  'apartment_title' => $secondUserSecondApartment->title,
				  'with_user_id' => $thirdUser->id,
				  'created_at' => Carbon::now(),
				  'updated_at' => Carbon::now(),
				],
				[
				  'reference_id' => (string)Str::uuid(),
				  'apartment_id' => $firstUserApartment->id,
				  'apartment_owner_nickname' => $firstUserApartment->owner()->nickname,
				  'apartment_title' => $firstUserApartment->title,
				  'with_user_id' => $secondUser->id,
				  'created_at' => Carbon::now(),
				  'updated_at' => Carbon::now(),
				],
			  ]
			);
			
		}
	}
