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
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
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
			$booking->status = 'pending';
			$booking->reference = (string)Str::uuid();
			$booking->user_id = $user->id;
			$booking->apartment_id = $apartment->id;
			$booking->apartment_title = $apartment->title;
			$booking->user_nickname = $user->nickname;
			$booking->check_in = Carbon::createFromFormat('d-m-Y', $data['check_in']);
			$booking->check_out = Carbon::createFromFormat('d-m-Y', $data['check_out']);
			$booking->special_requests = $data['special_requests'];
			$booking->apartment_amount = $apartment->calcCurrentPrice();
			$booking->save();
			if (array_key_exists('upgrades', $data)) {
				foreach ($data['upgrades'] as $upgrade) {
					$service = Service::findBySlug($upgrade);
					BookedService::create(
					  [
						'booking_id' => $booking->id,
						'name' => $service->name,
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
			
			$pendigBooking = Booking::where('status', 'pending')->where('apartment_id', $apartment->id)->where('user_id', $user->id)->first();
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
		 * Calc the amount for a booking
		 *
		 * @return float|int
		 */
		public function bookingAmount() {
			
			$baseAmount = $this->apartment_amount;
			foreach ($this->bookedServices()->get() as $upgrade) {
				$baseAmount += $upgrade->price_per_night == 0 ?: $upgrade->price_per_night;
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
		
	}
