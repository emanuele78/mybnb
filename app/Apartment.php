<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Cviebrock\EloquentSluggable\Sluggable;
	
	class Apartment extends Model {
		
		use Sluggable;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		protected $hidden = ['id', 'user_id'];
		
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
			
			return $this->activePromotion()->promotion_plan->card_type;
		}
		
		/**
		 * Return current active promo for apartment
		 *
		 * @return Promotion|null
		 */
		public function activePromotion(): ?Promotion {
			
			$activePromo = $this->promotions()->get()
			  ->where('start_at', '<=', Carbon::now())
			  ->where('end_at', '>=', Carbon::now())
			  ->first();
			if ($activePromo) {
				$activePromo->load('promotion_plan');
			}
			return $activePromo;
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
		 * @return array
		 */
		public static function promoted($item_count): array {
			
			return self::join('promotions', 'apartments.id', '=', 'promotions.apartment_id')
			  ->join('promotion_plans', 'promotions.promotion_plan_id', '=', 'promotion_plans.id')
			  ->where('promotions.start_at', '<=', Carbon::now())
			  ->where('promotions.end_at', '>=', Carbon::now())
			  ->where('apartments.is_showed', true)
			  ->orderBy('promotions.created_at', 'desc')
			  ->select(['apartments.slug', 'apartments.main_image', 'apartments.people_count', 'apartments.room_count', 'apartments.title', 'promotions.created_at', 'promotion_plans.card_type'])
			  ->take($item_count)->get()->toArray();
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
		
		/**
		 * Calc current price per night
		 *
		 * @param $sale
		 * @param $price_per_night
		 * @return float|int
		 */
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
		 * @param string $order_mode
		 * @return array
		 */
		public static function filterBy(int $user_id, ?bool $only_visible, ?bool $only_promoted, string $order_mode) {
			
			$builder = Apartment::where('user_id', $user_id)->with('promotions.promotion_plan');
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
			$coll = collect($data);
			switch ($order_mode) {
				case  'created_at':
				case  'updated_at':
				case  'title':
					$sorted = $coll->sortBy($order_mode);
					break;
				case 'created_at_desc':
					$sorted = $coll->sortByDesc('created_at');
					break;
				case 'updated_at_desc':
					$sorted = $coll->sortByDesc('updated_at');
					break;
				default:
					$sorted = $coll->sortBy('title');
				
			}
			return $sorted->values()->all();
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
		 *
		 * @param User $user
		 * @throws \Exception
		 */
		public function deleteAll(User $user) {
			
			//for all the threads related to the current apartment, set visible_for property
			Thread::removingApartment($this->id, $user);
			//proceed with deletion
			$this->delete();
		}
		
		/**
		 * Return all the available services for the current apartment together with remainig (not selected) services
		 *
		 * @return array
		 */
		public function discoverServices(): array {
			
			$services = [];
			foreach ($this->upgrades as $upgrade) {
				$services[] = [
				  'name' => $upgrade->service->name,
				  'slug' => $upgrade->service->slug,
				  'selected' => true,
				  'price_per_night' => $upgrade->price_per_night,
				];
			}
			$notSelectedServices = Service::notSelectedIn($this->id);
			foreach ($notSelectedServices as $notSelectedService) {
				$services[] = [
				  'name' => $notSelectedService->name,
				  'slug' => $notSelectedService->slug,
				  'selected' => false,
				  'price_per_night' => null,
				];
			}
			return $services;
		}
		
		/**
		 * Update info of current apartment
		 *
		 * @param array $data
		 */
		public function updateInfo(array $data) {
			
			$this->title = $data['title'];
			$this->description = $data['description'];
			$this->room_count = $data['room_count'];
			$this->people_count = $data['people_count'];
			$this->bathroom_count = $data['bathroom_count'];
			$this->square_meters = $data['square_meters'];
			$this->longitude = $data['address_lng'];
			$this->latitude = $data['address_lat'];
			$this->price_per_night = $data['price_per_night'];
			$this->max_stay = $data['max_stay'];
			if ($data['sale'] != null) {
				$this->sale = $data['sale'];
			}
			if (array_key_exists('is_showed', $data)) {
				$this->is_showed = true;
			}
			if ($data['images_changed'][0]) {
				$this->main_image = Image::storeFile($data['main_image']);
			}
			$this->save();
			//reserved days
			if (array_key_exists('reserved_days', $data)) {
				ReservedDay::replaceDays($this->id, $data['reserved_days']);
			}
			//upgrades
			if (array_key_exists('selected_services', $data)) {
				Upgrade::replaceExisting($this->id, $data['selected_services'], $data['services_price']);
			}
			//user defined services
			if (array_key_exists('new_services', $data)) {
				Upgrade::addNew($this->id, $data['new_services'], $data['new_services_prices']);
			}
			//additional images - remove
			for ($i = 1; $i < count($data['images_changed']); $i++) {
				if ($data['images_changed'][$i]) {
					Image::removeFor($this->id, $i);
				}
			}
			//additional images - add new
			if (array_key_exists('other_images', $data)) {
				Image::storeAdditional($this->id, $data['other_images']);
			}
			Image::refactorIndexes($this->id);
		}
		
		/**
		 * Return max price found in all apartments
		 *
		 * @return mixed
		 */
		public static function findMaxPrice(): float {
			
			return self::select('price_per_night')->orderBy('price_per_night', 'desc')->take(1)->get()->first()->price_per_night;
		}
		
		/**
		 * Scope for haversine formula
		 *
		 * @param $query
		 * @param $radius
		 * @param $latitude
		 * @param $longitude
		 * @param $orderByDistance
		 * @return mixed
		 */
		public function scopeFindInRange($query, $radius, $latitude, $longitude, $orderByDistance) {
			
			$haversine = "(6372 * acos(cos(radians($latitude))
                     * cos(radians(latitude))
                     * cos(radians(longitude)
                     - radians($longitude))
                     + sin(radians($latitude))
                     * sin(radians(latitude))))";
			$query
			  ->select('*')
			  ->selectRaw("{$haversine} AS distance")
			  ->whereRaw("{$haversine} <= ?", [$radius]);
			if ($orderByDistance) {
				$query->orderByRaw('distance');
			}
			return $query;
		}
		
		/**
		 * Return apartments match given criteria
		 *
		 * @param $userData
		 * @return mixed
		 */
		public static function search($userData, $results_for_page) {
			
			//retrieve city code
			$searchedCity = config('cities')[$userData['city_code']];
			//create builder passing city lat/long to haversine formula
			$builder = Apartment::findInRange($userData['distance_radius'], $searchedCity['lat'], $searchedCity['lng'], $userData['order_by'] == 'distance');
			//people query clause
			$builder->where('people_count', '>=', $userData['people_count'])
			  ->whereBetween('price_per_night', $userData['price_range']);
			//selected services query clause
			if (!empty($userData['services'])) {
				foreach ($userData['services'] as $service) {
					$builder->whereHas(
					  'upgrades.service', function ($query) use ($service) {
						
						$query->where('slug', $service);
					});
				}
			};
			//check-in/check-out (if not null)
			if ($userData['check_in'] != null) {
				$max_life_pending_booking = config('project.pending_booking_max_life');
				//if check-in was inserted, also check-out is present
				//parse data values
				$checkIn = Carbon::createFromFormat('d-m-Y', $userData['check_in'])->startOfDay();
				$checkOut = Carbon::createFromFormat('d-m-Y', $userData['check_out'])->startOfDay();
				//check if date range overlaps some reserved days set by the host
				$builder->whereDoesntHave(
				  'reservedDays', function ($query) use ($checkIn, $checkOut) {
					
					$query->where('day', '>=', $checkIn)
					  ->where('day', '<=', $checkOut);
				});
				//after check if there are some booking in date range
				$builder->whereDoesntHave(
				  'bookings', function ($query) use ($checkIn, $checkOut, $max_life_pending_booking) {
					
					$query->where('check_out', '>', $checkIn)->where('check_in', '<', $checkOut)
					  ->where(
					  //where booking is confirmed or where booking is pending but not expired
						function ($query) use ($max_life_pending_booking) {
							
							$query->where('status', 'confirmed')->orWhere(
							  function ($query) use ($max_life_pending_booking) {
								  
								  $query->where('status', 'pending')->where('created_at', '>=', Carbon::now()->addMinutes(-$max_life_pending_booking));
							  });
						});
				});
			}
			//order
			if ($userData['order_by'] != 'distance') {
				$builder->orderBy($userData['order_by']);
			}
			return $builder->paginate($results_for_page);
		}
		
	}
