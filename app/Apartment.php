<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Cviebrock\EloquentSluggable\Sluggable;
	
	class Apartment extends Model {
		
		use Sluggable;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Set key for route model binding
		 *
		 * @return string
		 */
		public function getRouteKeyName() {
			
			return 'slug';
		}
		
		/**
		 * Accessor for formatting date
		 *
		 * @param $value
		 * @return string
		 */
		public function getUpdatedAtAttribute($value) {
			
			return Carbon::create($value)->format('d-m-Y');
		}
		
		/**
		 * Return the sluggable configuration array for this model.
		 *
		 * @return array
		 */
		public function sluggable() {
			
			return [
			  'slug' => [
				'source' => 'title'
			  ]
			];
		}
		
		/**
		 * Return a string describing the current active promotion plan
		 *
		 * @return string
		 */
		public function activePromotionPlan(): string {
			
			return $this->promotions()->get()
			  ->where('start_at', '<=', Carbon::now())
			  ->where('end_at', '>=', Carbon::now())
			  ->first()->promotion_plan->card_type;
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function promotions() {
			
			return $this->hasMany(Promotion::class);
		}
		
		/**
		 * Return the full name for the main image
		 *
		 * @return string
		 */
		public function mainImage(): string {
			
			return $this->images()->first()->name;
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function images() {
			
			return $this->hasMany(Image::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function reservedDays() {
			
			return $this->hasMany(ReservedDay::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function bookings() {
			
			return $this->hasMany(Booking::class);
		}
		
		/**
		 * Return a collection of $item_count promoted apartments
		 *
		 * @param $item_count
		 * @return mixed
		 */
		public static function promoted($item_count) {
			
			return self::where('is_showed', true)
			  ->whereHas(
				'promotions', function ($query) {
				  
				  $query->where('start_at', '<=', Carbon::now())->where('end_at', '>=', Carbon::now());
			  })
			  ->take($item_count)->get();
		}
		
		/**
		 * Return an apartment by slug
		 *
		 * @param $slug
		 * @return mixed
		 */
		public static function findBySlug($slug): ?self {
			
			return Apartment::where('slug', $slug)->first();
		}
		
		/**
		 * Check if the passed service slug belongs to the current apartment as upgrade
		 *
		 * @param $service_slug
		 * @return bool
		 */
		public function hasUpgrade($service_slug): bool {
			
			foreach ($this->upgrades()->get() as $upgrade) {
				if ($upgrade->service->slug == $service_slug) {
					return true;
				}
			}
			return false;
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function upgrades() {
			
			return $this->hasMany(Upgrade::class);
		}
		
		/**
		 * Return the current price for the apartment
		 *
		 * @return float|int|mixed
		 */
		public function calcCurrentPrice() {
			
			if ($this->sale > 0) {
				
				return $this->price_per_night - $this->price_per_night * $this->sale / 100;
			}
			return $this->price_per_night;
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function threads() {
			
			return $this->hasMany(Thread::class);
		}
		
		/**
		 * @return mixed
		 */
		public function owner() {
		    return $this->user;
		}
		
	}
