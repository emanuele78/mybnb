<?php
	
	use App\PromotionPlan;
	use Illuminate\Database\Seeder;
	
	class PromotionPlansTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$cardsType = ['standard' => 5, 'big' => 18, 'horizontal' => 9, 'vertical' => 9];
			foreach ($cardsType as $key => $value) {
				PromotionPlan::create(
				  [
					'card_type' => $key,
					'price_per_day' => $value,
					'max_length' => 7
				  ]);
			}
		}
	}
