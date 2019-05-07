<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class PromotionPlan extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Eloquent relationships
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function promotions() {
			
			return $this->hasMany(Promotion::class);
		}
		
		/**
		 * Return a list of all available promo
		 *
		 * @return array
		 */
		public static function available(): array {
			
			return self::where('active', 1)->orderBy('price_per_day', 'desc')->get()->toArray();
		}
		
		/**
		 * Check if the given promotion type is active
		 *
		 * @param string $card_type
		 * @return bool
		 */
		public static function isActive(string $card_type): bool {
			
			try {
				return self::where('card_type', $card_type)->get()->first()->active;
			} catch (\Exception $e) {
				return false;
			}
		}
		
		/**
		 * Check is the given lenght exceed the promotion type
		 *
		 * @param string $card_type
		 * @param string $day
		 * @return bool
		 */
		public static function validLength(string $card_type, string $day): bool {
			
			try {
				return self::where('card_type', $card_type)->get()->first()->max_length >= $day;
			} catch (\Exception $e) {
				return false;
			}
		}
		
		/**
		 * Return id by given card type
		 *
		 * @param string $type
		 * @return int
		 */
		public static function findByType(string $type): int {
			
			return self::where('card_type', $type)->get()->first()->id;
		}
	}
