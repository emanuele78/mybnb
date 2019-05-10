<?php
	
	use App\Apartment;
	use App\PromotionPlan;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	
	class PromotionsTableSeeder extends Seeder {
		
		protected $apartments_to_promote = 80;
		
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			
			if (!config('project.use_debug_mode_when_seeding')) {
				$this->seedForProductionDemo();
				return;
			}
			$future_days = 5;
			$promotionPlans = PromotionPlan::get();
			$apartments = Apartment::take($this->apartments_to_promote)->get();
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
					$this->store($apartment->id, $expiredPromotionPlan->id, $expiredPlanStartDate, $expiredPlanEndDate);
					$this->store($apartment->id, $futurePromotionPlan->id, $futurePlanStartDate, $futurePlanEndDate);
				} else {
					//one promotion active and one expired
					$this->store($apartment->id, $promotionPlan->id, $startDate, $endDate);
					$this->store($apartment->id, $expiredPromotionPlan->id, $expiredPlanStartDate, $expiredPlanEndDate);
				}
			}
		}
		
		private function seedForProductionDemo() {
			
			$apartments = Apartment::take($this->apartments_to_promote)->get();
			$startDate = Carbon::now();
			$promotionPlans = PromotionPlan::get();
			foreach ($apartments as $key => $apartment) {
				$promotionPlan = $promotionPlans[rand(0, count($promotionPlans) - 1)];
				$endDate = $startDate->copy()->addDays($promotionPlan->max_length);
				$this->store($apartment->id, $promotionPlan->id, $startDate, $endDate);
			}
		}
		
		private function store($apartment_id, $plan_id, $start, $end) {
			
			$randomDate = Carbon::now()->addDays(-rand(10, 100));
			DB::table('promotions')->insert(
			  [
				'apartment_id' => $apartment_id,
				'reference' => Str::uuid(),
				'promotion_plan_id' => $plan_id,
				'start_at' => $start,
				'end_at' => $end,
				'created_at' => $randomDate,
				'updated_at' => $randomDate
			  ]
			);
		}
	}
