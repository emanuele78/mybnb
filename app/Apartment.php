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
		public function getCreatedAtAttribute($value) {
			
			return $this->getUpdatedAtAttribute($value);
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
			
			return self::calcPrice($this->sale, $this->price_per_night);
		}
		
		public static function calcPrice($sale, $price_per_night) {
			
			if ($sale > 0) {
				
				return $price_per_night - $price_per_night * $sale / 100;
			}
			return $price_per_night;
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
		
		/**
		 * @param int $user_id
		 * @param bool|null $only_visible
		 * @param bool|null $only_promoted
		 * @return array
		 */
		public static function filterBy(int $user_id, ?bool $only_visible, ?bool $only_promoted) {
			
			$builder = Apartment::where('user_id', $user_id)->with('promotions.promotion_plan')->orderBy('created_at');
			if ($only_visible !== null) {
				$builder->where('is_showed', $only_visible);
			}
			if ($only_promoted !== null) {
				if ($only_promoted) {
					$builder->whereHas(
					  'promotions', function ($query) {
						
						$query->where('start_at', '<=', Carbon::now())->where('end_at', '>=', Carbon::now());
					});
				} else {
					$builder->whereDoesntHave(
					  'promotions', function ($query) {
						
						$query->where('start_at', '<=', Carbon::now())->where('end_at', '>=', Carbon::now());
					});
				}
			}
			$data = [];
			foreach ($builder->get()->toArray() as $apartment) {
				$item = [
				  'image' => $apartment['main_image'],
				  'title' => $apartment['title'],
				  'slug' => $apartment['slug'],
				  'full_price_per_night' => $apartment['price_per_night'],
				  'in_sale' => $apartment['sale'] > 0 ?: false,
				  'is_visible' => $apartment['is_showed'] == 1 ?: false,
				  'created_at' => $apartment['created_at'],
				  'updated_at' => $apartment['updated_at'],
				  'active_promotion' => false
				];
				if ($item['in_sale']) {
					$item['sale_price'] = self::calcPrice($apartment['sale'], $apartment['price_per_night']);
				}
				if (!empty($apartment['promotions'])) {
					$found = false;
					$i = 0;
					do {
						if (Carbon::createFromFormat('Y-m-d H:i:s', $apartment['promotions'][$i]['start_at']) <= Carbon::now() && Carbon::createFromFormat('Y-m-d H:i:s', $apartment['promotions'][$i]['end_at']) >= Carbon::now()) {
							$item['active_promotion'] = $apartment['promotions'][$i]['promotion_plan']['name'];
							$item['active_promotion_end'] = Utility::dateTimeLocale($apartment['promotions'][$i]['end_at'], true);
							$item['active_promotion_start'] = Utility::dateTimeLocale($apartment['promotions'][$i]['start_at'], true);
							$found = true;
						}
					} while (++$i < count($apartment['promotions']) && $found == false);
				}
				$data[] = $item;
			}
			return $data;
		}
		
		/**
		 * Set the visibility of the current apartment
		 *
		 * @param bool $value
		 */
		public function visibility(bool $value) {
			
			$this->is_showed = $value;
			$this->update();
		}
		
		/**
		 * Save a new apartment for the given user with the given data
		 *
		 * @param $data
		 * @param $user_id
		 * @return void
		 */
		public static function createNew($data, $user_id): void {
			
			//apartment info
			$apartment = new Apartment();
			$apartment->user_id = $user_id;
			$apartment->title = $data['title'];
			$apartment->main_image = Image::storeFile($data['main_image']);
			$apartment->description = $data['description'];
			$apartment->room_count = $data['room_count'];
			$apartment->people_count = $data['people_count'];
			$apartment->bathroom_count = $data['bathroom_count'];
			$apartment->square_meters = $data['square_meters'];
			$apartment->longitude = $data['address_lng'];
			$apartment->latitude = $data['address_lat'];
			$apartment->price_per_night = $data['price_per_night'];
			$apartment->max_stay = $data['max_stay'];
			if ($data['sale'] != null) {
				$apartment->sale = $data['sale'];
			}
			if (array_key_exists('is_showed', $data)) {
				$apartment->is_showed = true;
			}
			$apartment->save();
			//reserved days
			if (array_key_exists('reserved_days', $data)) {
				ReservedDay::addDays($apartment->id, $data['reserved_days']);
			}
			//additional images
			if (array_key_exists('other_images', $data)) {
				Image::storeAdditional($apartment->id, $data['other_images']);
			}
			//upgrades
			if (array_key_exists('selected_services', $data)) {
				Upgrade::addExistings($apartment->id, $data['selected_services'], $data['services_price']);
			}
			//user defined services
			if (array_key_exists('new_services', $data)) {
				Upgrade::addNew($apartment->id, $data['new_services'], $data['new_services_prices']);
			}
		}
		
		/**
		 * Return array with all the image names related to the current apartment
		 *
		 * @return array
		 */
		public function allRelatedImages(): array {
			
			$images = [];
			$images[] = $this->main_image;
			foreach ($this->images()->get() as $image) {
				$images[] = $image->name;
			}
			return $images;
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
		 * Delete all the data for the current apartment
		 */
		public function deleteAll() {
		
		}
		
	}
