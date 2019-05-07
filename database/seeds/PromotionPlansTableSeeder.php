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
				  'active' => 1,
				  'card_type' => 'standard',
				  'image' => 'card_small.jpg',
				  'price_per_day' => 5,
				  'name' => 'promo card piccola',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
				[
				  'active' => 1,
				  'card_type' => 'big',
				  'image' => 'card_big.jpg',
				  'price_per_day' => 18,
				  'name' => 'promo card grande',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
				[
				  'active' => 1,
				  'card_type' => 'horizontal',
				  'image' => 'card_horizontal.jpg',
				  'price_per_day' => 9,
				  'name' => 'promo card orizzontale',
				  'max_length' => 7,
				  'created_at' => $now,
				  'updated_at' => $now
				],
				[
				  'active' => 1,
				  'card_type' => 'vertical',
				  'image' => 'card_vertical.jpg',
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
