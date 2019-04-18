<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class Booking extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $casts = [
		  'check_in' => 'date',
		  'check_out' => 'date',
		];
		
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
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
		
		public static function removePending($user, $apartment) {
			
			$pendigBooking = Booking::where('status', 'pending')->where('apartment_id', $apartment->id)->where('user_id', $user->id)->first();
			if ($pendigBooking != null) {
				$pendigBooking->delete();
			}
		}
		
		public static function isExpired($reference, $expireTime) {
			
			$booking = self::findByReference($reference);
			return Carbon::now()->diffInMinutes($booking->created_at) > $expireTime;
		}
		
		public static function findByReference($reference) {
			
			return Booking::where('reference', $reference)->first();
		}
		
		public function bookingAmount() {
			
			$baseAmount = $this->apartment_amount;
			foreach ($this->bookedServices()->get() as $upgrade) {
				$baseAmount += $upgrade->price_per_night == 0 ?: $upgrade->price_per_night;
			}
			return $baseAmount * $this->check_out->diffInDays($this->check_in);
		}
		
		public function bookedServices() {
			
			return $this->hasMany(BookedService::class);
		}
		
		public function confirm() {
			
			$this->status = 'confirmed';
			$this->save();
		}
		
		public static function forApartment($apartment_id) {
			
			return Booking::where('apartment_id', $apartment_id)->get();
		}
		
	}
