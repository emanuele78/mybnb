<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class Booking extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Casting for the following fields
		 *
		 * @var array
		 */
		protected $casts = [
		  'check_in' => 'date',
		  'check_out' => 'date',
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
		public function user() {
			
			return $this->belongsTo(User::class, 'user_booking_id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class, 'apartment_id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartmentOwner() {
			
			return $this->belongsTo(User::class, 'apartment_owner_id');
		}
		
		/**
		 * Create and save new booking with pending state. If pending booking exists for the same  user/apartmente, it will be removed
		 *
		 * @param $data
		 * @param $user
		 * @param $apartment
		 * @return Booking
		 */
		public static function addPendingBooking($data, $user, $apartment) {
			
			//if a pending booking exists for the same $user and $apartment, it will be deleted
			self::removePending($user, $apartment);
			//add new pending booking with related services
			$booking = new Booking();
			$booking->reference = (string)Str::uuid();
			$booking->status = 'pending';
			
			$booking->user_booking_id = $user->id;
			$booking->user_booking_nickname = $user->nickname;
			$booking->user_booking_fullname = $user->fullname();
			$booking->user_booking_address = $user->customer->streetAddress;
			$booking->user_booking_full_locality = $user->fullLocality();
			$booking->user_booking_email = $user->email;
			
			$booking->apartment_id = $apartment->id;
			$booking->apartment_slug = $apartment->slug;
			$booking->apartment_title = $apartment->title;
			$booking->apartment_owner_id = $apartment->user->id;
			$booking->apartment_owner_nickname = $apartment->user->nickname;
			$booking->apartment_owner_fullname = $apartment->user->fullname();
			$booking->apartment_owner_address = $apartment->user->customer->streetAddress;
			$booking->apartment_owner_full_locality = $apartment->user->fullLocality();
			$booking->apartment_owner_email = $apartment->user->email;
			$booking->apartment_image = $apartment->main_image;
			
			$booking->check_in = Carbon::createFromFormat('d-m-Y', $data['check_in']);
			$booking->check_out = Carbon::createFromFormat('d-m-Y', $data['check_out']);
			
			$booking->special_requests = $data['special_requests'];
			$booking->apartment_price_per_night = $apartment->calcCurrentPrice();
			$booking->save();
			if (array_key_exists('upgrades', $data)) {
				foreach ($data['upgrades'] as $upgrade) {
					$service = Service::findBySlug($upgrade);
					BookedService::create(
					  [
						'booking_id' => $booking->id,
						'name' => $service->name,
						'slug' => $service->slug,
						'price_per_night' => $apartment->upgrades()->where('service_id', $service->id)->first()->price_per_night
					  ]
					);
				}
			}
			return $booking;
		}
		
		/**
		 * Remove a pending booking for user/apartment if exists
		 *
		 * @param $user
		 * @param $apartment
		 */
		public static function removePending($user, $apartment) {
			
			$pendigBooking = Booking::where('status', 'pending')->where('apartment_id', $apartment->id)->where('user_booking_id', $user->id)->first();
			if ($pendigBooking != null) {
				$pendigBooking->delete();
			}
		}
		
		/**
		 * Check if a booking in pending state is expired
		 *
		 * @param $reference
		 * @param $expireTime
		 * @return bool
		 */
		public static function isExpired($reference, $expireTime): bool {
			
			$booking = self::findByReference($reference);
			return Carbon::now()->diffInMinutes($booking->created_at) > $expireTime;
		}
		
		/**
		 * Return a booking given the reference number
		 *
		 * @param $reference
		 * @return mixed
		 */
		public static function findByReference($reference) {
			
			return Booking::where('reference', $reference)->first();
		}
		
		/**
		 * Change the status of a pending booking to confirmed
		 */
		public function confirm() {
			
			$this->status = 'confirmed';
			$this->save();
		}
		
		/**
		 * Return all the booking for a given apartment
		 *
		 * @param $apartment_id
		 * @return mixed
		 */
		public static function forApartment($apartment_id) {
			
			return Booking::where('apartment_id', $apartment_id)->get();
		}
		
		/**
		 * Return all the bookings made for the given user apartments
		 *
		 * @param int $user_id
		 * @param bool $onlyFutureBookings
		 * @return array
		 */
		public static function forUserApartments(int $user_id, bool $onlyFutureBookings) {
			
			$builder = self::where('apartment_owner_id', $user_id)->where('status', 'confirmed')->with('bookedServices');
			if ($onlyFutureBookings) {
				$builder->where('check_out', '>', Carbon::now());
			}
			$apartmentsWithBookings = $builder->get()->groupBy('apartment_id')->toArray();
			$data = [];
			//apartments loop
			foreach ($apartmentsWithBookings as $key => $apartmentWithBookings) {
				$singleApartment =
				  [
					'apartment_title' => $apartmentWithBookings[0]['apartment_title'],
					'apartment_active' => !empty($key),
					'apartment_slug' => $apartmentWithBookings[0]['apartment_slug'],
					'apartment_image' => $apartmentWithBookings[0]['apartment_image'],
					'apartment_owner_nickname' => $apartmentWithBookings[0]['apartment_owner_nickname'],
					'apartment_owner_fullname' => $apartmentWithBookings[0]['apartment_owner_fullname'],
					'apartment_owner_email' => $apartmentWithBookings[0]['apartment_owner_email'],
					"bookings" => []
				  ];
				//booking loop
				foreach ($apartmentWithBookings as $booking) {
					$singleBooking =
					  [
						'booking_reference' => $booking['reference'],
						'status' => $booking['status'],
						'user_nickname' => $booking['user_booking_nickname'],
						'user_fullname' => $booking['user_booking_fullname'],
						'user_email' => $booking['user_booking_email'],
						'check_in' => Utility::dateTimeLocale($booking['check_in'], false),
						'check_out' => Utility::dateTimeLocale($booking['check_out'], false),
						'nights_count' => Utility::diffInDays($booking['check_in'], $booking['check_out']),
						'total_amount' => '',
						'confirmed_at' => Utility::dateTimeLocale($booking['created_at'], true),
						'upgrades' => [],
					  ];
					$upgrade_amout_per_night = 0;
					//upgrades loop
					foreach ($booking['booked_services'] as $booked_service) {
						$services =
						  [
							'service_name' => $booked_service['name'],
							'service_price' => $booked_service['price_per_night'],
						  ];
						$singleBooking['upgrades'][] = $services;
						$upgrade_amout_per_night += $booked_service['price_per_night'];
					}
					$singleBooking['total_amount'] = ($booking['apartment_price_per_night'] + $upgrade_amout_per_night) * $singleBooking['nights_count'];
					$singleApartment['bookings'][] = $singleBooking;
				}
				$data[] = $singleApartment;
			}
			return $data;
		}
		
		/**
		 * Return all the bookings made to other user apartments
		 *
		 * @param int $user_id
		 * @param bool $onlyFutureBookings
		 * @param bool $onlyPending
		 * @return array
		 */
		public static function forOtherApartments(int $user_id, bool $onlyFutureBookings, bool $onlyPending) {
			
			$builder = self::where('user_booking_id', $user_id)->with('bookedServices');
			if ($onlyFutureBookings) {
				$builder->where('check_out', '>', Carbon::now());
			}
			if ($onlyPending) {
				$builder->where('status', 'pending');
			} else {
				$builder->where('status', 'confirmed');
			}
			$apartmentsWithBookings = $builder->get()->groupBy('apartment_id')->toArray();
			$data = [];
			//apartments loop
			foreach ($apartmentsWithBookings as $key => $apartmentWithBookings) {
				$singleApartment =
				  [
					'apartment_title' => $apartmentWithBookings[0]['apartment_title'],
					'apartment_active' => !empty($key),
					'apartment_slug' => $apartmentWithBookings[0]['apartment_slug'],
					'apartment_image' => $apartmentWithBookings[0]['apartment_image'],
					'apartment_owner_nickname' => $apartmentWithBookings[0]['apartment_owner_nickname'],
					'apartment_owner_fullname' => $apartmentWithBookings[0]['apartment_owner_fullname'],
					'apartment_owner_email' => $apartmentWithBookings[0]['apartment_owner_email'],
					"bookings" => []
				  ];
				//booking loop
				foreach ($apartmentWithBookings as $booking) {
					$singleBooking =
					  [
						'booking_reference' => $booking['reference'],
						'status' => $booking['status'],
						'user_nickname' => $booking['user_booking_nickname'],
						'user_fullname' => $booking['user_booking_fullname'],
						'user_email' => $booking['user_booking_email'],
						'check_in' => Utility::dateTimeLocale($booking['check_in'], false),
						'check_out' => Utility::dateTimeLocale($booking['check_out'], false),
						'nights_count' => Utility::diffInDays($booking['check_in'], $booking['check_out']),
						'total_amount' => '',
						'confirmed_at' => Utility::dateTimeLocale($booking['created_at'], true),
						'upgrades' => [],
					  ];
					$upgrade_amout_per_night = 0;
					//upgrades loop
					foreach ($booking['booked_services'] as $booked_service) {
						$services =
						  [
							'service_name' => $booked_service['name'],
							'service_price' => $booked_service['price_per_night'],
						  ];
						$singleBooking['upgrades'][] = $services;
						$upgrade_amout_per_night += $booked_service['price_per_night'];
					}
					$singleBooking['total_amount'] = ($booking['apartment_price_per_night'] + $upgrade_amout_per_night) * $singleBooking['nights_count'];
					$singleApartment['bookings'][] = $singleBooking;
				}
				$data[] = $singleApartment;
			}
			return $data;
		}
		
		/**
		 * Return an array of data for the current booking used to generate a receipt pdf
		 *
		 * @return array
		 */
		public function dataForInvoice() {
			
			$data = [
			  'booking_reference' => $this->reference,
			  'booking_date' => Utility::dateTimeLocale($this->updated_at, false),
			  'user_booking_fullname' => $this->user_booking_fullname,
			  'user_booking_address' => $this->user_booking_address,
			  'user_booking_locality' => $this->user_booking_full_locality,
			  'user_booking_email' => $this->user_booking_email,
			  'user_booking_tax_code' => $this->user->customer->taxCode,
			  'apartment_owner_fullname' => $this->apartment_owner_fullname,
			  'apartment_owner_tax_code' => $this->apartmentOwner->customer->taxCode,
			  'apartment_owner_address' => $this->apartment_owner_address,
			  'apartment_owner_locality' => $this->apartment_owner_full_locality,
			  'apartment_owner_email' => $this->apartment_owner_email,
			  'apartment_title' => $this->apartment_title,
			  'apartment_price_per_night' => $this->apartment_price_per_night,
			  'check_in' => Utility::dateTimeLocale($this->check_in, false),
			  'check_out' => Utility::dateTimeLocale($this->check_out, false),
			  'nights_count' => Utility::diffInDays($this->check_in, $this->check_out),
			  'total_amount' => $this->bookingAmount(),
			  'has_upgrades' => $this->bookedServices()->exists(),
			];
			if ($data['has_upgrades']) {
				$data['upgrades'] = [];
				foreach ($this->bookedServices()->get() as $bookedService) {
					$data['upgrades'][] =
					  [
						'name' => $bookedService->name,
						'price_per_night' => $bookedService->price_per_night,
					  ];
				}
			}
			return $data;
		}
		
		/**
		 * Calc the amount for a booking
		 *
		 * @return float|int
		 */
		public function bookingAmount() {
			
			$baseAmount = $this->apartment_price_per_night;
			foreach ($this->bookedServices()->get() as $upgrade) {
				$baseAmount += $upgrade->price_per_night == 0 ? 0 : $upgrade->price_per_night;
			}
			return $baseAmount * $this->check_out->diffInDays($this->check_in);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function bookedServices() {
			
			return $this->hasMany(BookedService::class);
		}
		
		/**
		 * Resume the data for a pending booking, apartment data need to be actualized
		 *
		 * @return array
		 */
		public function resume(): array {
			
			$data =
			  [
				'apartment' => $this->apartment,
				'stay' => [
				  'check_in' => $this->check_in->format('d-m-Y'),
				  'check_out' => $this->check_out->format('d-m-Y'),
				  'requests' => $this->special_requests
				],
				'pending_upgrades' => [],
			  ];
			foreach ($this->bookedServices as $bookedService) {
				$data['pending_upgrades'][] = $bookedService->slug;
			}
			return $data;
		}
		
	}
