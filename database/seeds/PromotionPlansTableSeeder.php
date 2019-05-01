<?php
	
	use Illuminate\Database\Seeder;
	
	class PromotionPlansTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$now = \Carbon\Carbon::now();
			$plans =
			  [
				[
				  'card_type' => 'standard',
				  'price_per_day' => 5,
				  'name' => 'promo card piccola',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
				[
				  'card_type' => 'big',
				  'price_per_day' => 18,
				  'name' => 'promo card grande',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
				[
				  'card_type' => 'horizontal',
				  'price_per_day' => 9,
				  'name' => 'promo card orizzontale',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
				[
				  'card_type' => 'vertical',
				  'price_per_day' => 9,
				  'name' => 'promo card verticale',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
			  ];
			DB::table('promotion_plans')->insert($plans);
		}
	}
