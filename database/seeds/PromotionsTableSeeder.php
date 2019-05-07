<?php
	
	use App\Apartment;
	use App\PromotionPlan;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	
	class PromotionsTableSeeder extends Seeder {
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			$future_days = 5;
			$apartments_to_promote = 80;
			$promotionPlans = PromotionPlan::get();
			$apartments = Apartment::take($apartments_to_promote)->get();
			$expiredPlanStartDate = Carbon::now()->addDays(-10);
			$expiredPlanEndDate = Carbon::now()->addDays(-5);
			$startDate = Carbon::now();
			$futurePlanStartDate = Carbon::now()->addDays($future_days);
			foreach ($apartments as $key => $apartment) {
				
				$promotionPlan = $promotionPlans[rand(0, count($promotionPlans) - 1)];
				$expiredPromotionPlan = $promotionPlans[rand(0, count($promotionPlans) - 1)];
				$futurePromotionPlan = $promotionPlans[rand(0, count($promotionPlans) - 1)];
				$futurePlanEndDate = Carbon::now()->addDays($future_days)->addDays($promotionPlan->max_length);
				$endDate = Carbon::now()->addDays($promotionPlan->max_length);
				if ($key >= 50) {
					//one promotion expired and one future
					DB::table('promotions')->insert(
					  [
						[
						  'apartment_id' => $apartment->id,
						  'reference' => Str::uuid(),
						  'promotion_plan_id' => $expiredPromotionPlan->id,
						  'start_at' => $expiredPlanStartDate,
						  'end_at' => $expiredPlanEndDate,
						  'created_at' => $startDate,
						  'updated_at' => $startDate
						],
						[
						  'apartment_id' => $apartment->id,
						  'reference' => Str::uuid(),
						  'promotion_plan_id' => $futurePromotionPlan->id,
						  'start_at' => $futurePlanStartDate,
						  'end_at' => $futurePlanEndDate,
						  'created_at' => $startDate,
						  'updated_at' => $startDate
						]
					  ]
					);
				} else {
					//one promotion active and one expired
					DB::table('promotions')->insert(
					  [
						[
						  'apartment_id' => $apartment->id,
						  'reference' => Str::uuid(),
						  'promotion_plan_id' => $promotionPlan->id,
						  'start_at' => $startDate,
						  'end_at' => $endDate,
						  'created_at' => $startDate,
						  'updated_at' => $startDate
						],
						[
						  'apartment_id' => $apartment->id,
						  'reference' => Str::uuid(),
						  'promotion_plan_id' => $expiredPromotionPlan->id,
						  'start_at' => $expiredPlanStartDate,
						  'end_at' => $expiredPlanEndDate,
						  'created_at' => $startDate,
						  'updated_at' => $startDate
						]
					  ]
					);
				}
			}
		}
	}
