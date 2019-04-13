<?php
	
	use App\Apartment;
	use App\Promotion;
	use App\PromotionPlan;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class PromotionsTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$apartments_to_promote = 50;
			$promotionPlans = PromotionPlan::get();
			$apartments = Apartment::take($apartments_to_promote)->get();
			foreach ($apartments as $apartment) {
				$promotionPlan = $promotionPlans[rand(0, count($promotionPlans) - 1)];
				$startDate = Carbon::now();
				$endDate = Carbon::now()->addDays($promotionPlan->max_length);
				Promotion::create(
				  [
					'apartment_id' => $apartment->id,
					'promotion_plan_id' => $promotionPlan->id,
					'start_at' => $startDate,
					'end_at' => $endDate,
					'paid' => $promotionPlan->max_length * $promotionPlan->price_per_day
				  ]);
			}
		}
	}
