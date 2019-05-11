<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class Promotion extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Casted field
		 *
		 * @var array
		 */
		protected $casts = [
		  'start_at' => 'datetime',
		  'end_at' => 'datetime',
		];
		
		/**
		 * Set key for route model binding
		 *
		 * @return string
		 */
		public function getRouteKeyName() {
			
			return 'reference';
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function promotion_plan() {
			
			return $this->belongsTo(PromotionPlan::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		/**
		 * Retrieve list of promotion for the given apartment
		 *
		 * @param $apartment_id
		 * @return array
		 */
		public static function listFor($apartment_id): array {
			
			return self::where('apartment_id', $apartment_id)->with('promotion_plan')->orderBy('created_at')->get()->toArray();
		}
		
		/**
		 * Check if given new promotion data overlaps existing promotion for the given apartment
		 *
		 * @param int $apartment_id
		 * @param string|null $new_promotion_start
		 * @param string $day_length
		 * @return bool
		 */
		public static function overlaps(int $apartment_id, ?string $new_promotion_start, string $day_length): bool {
			
			if ($new_promotion_start) {
				$userPromoStart = Carbon::createFromFormat('d-m-Y H:i', $new_promotion_start);
			} else {
				$userPromoStart = Carbon::now();
			}
			$userPromoEnd = $userPromoStart->copy()->addDays($day_length);
			foreach (self::where('apartment_id', $apartment_id)->get() as $promotion) {
				if (($userPromoStart->lessThanOrEqualTo($promotion->end_at)) && ($promotion->start_at->lessThanOrEqualTo($userPromoEnd))) {
					return true;
				}
			}
			return false;
		}
		
		/**
		 * Calc promotion price for given data
		 *
		 * @param string $day_length
		 * @param $promo_type
		 * @return float|int
		 */
		public static function calcPrice(string $day_length, string $promo_type) {
			
			$base_price = PromotionPlan::where('card_type', $promo_type)->get()->first()->price_per_day;
			return $base_price * $day_length;
		}
		
		/**
		 * Store new promotion with given data for the given apartment
		 *
		 * @param int $apartment_id
		 * @param string|null $new_promotion_start
		 * @param string $day_length
		 * @param string $promo_type
		 */
		public static function createFor(int $apartment_id, ?string $new_promotion_start, string $day_length, string $promo_type): void {
			
			if ($new_promotion_start) {
				$userPromoStart = Carbon::createFromFormat('d-m-Y H:i', $new_promotion_start);
			} else {
				$userPromoStart = Carbon::now();
			}
			$userPromoEnd = $userPromoStart->copy()->addDays($day_length);
			Promotion::create(
			  [
				'apartment_id' => $apartment_id,
				'reference' => Str::uuid(),
				'promotion_plan_id' => PromotionPlan::findByType($promo_type),
				'start_at' => $userPromoStart,
				'end_at' => $userPromoEnd,
			  ]);
		}
		
		/**
		 * Return promotion data for invoice
		 *
		 * @return array
		 */
		public function dataForInvoice(): array {
			
			$user = $this->apartment->owner();
			return [
			  'promo_reference' => $this->reference,
			  'promo_date' => Utility::dateTimeLocale($this->created_at, false),
			  'user_fullname' => $user->fullname(),
			  'user_tax_code' => $user->customer->taxCode,
			  'user_address' => $user->customer->streetAddress,
			  'user_locality' => $user->fullLocality(),
			  'user_email' => $user->email,
			  'apartment_title' => $this->apartment->title,
			  'days_count' => Utility::diffInDays($this->start_at, $this->end_at),
			  'price_per_day' => $this->promotion_plan->price_per_day,
			  'promo_start' => Utility::dateTimeLocale($this->start_at, true),
			  'promo_end' => Utility::dateTimeLocale($this->end_at, true),
			  'promo_type' => $this->promotion_plan->name,
			];
		}
		
	}
