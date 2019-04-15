<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Cviebrock\EloquentSluggable\Sluggable;
	
	class Apartment extends Model {
		
		use Sluggable;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		protected $with = ['images', 'upgrades', 'user'];
		
		public function getRouteKeyName() {
			
			return 'slug';
		}
		
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
		
		public function promotions() {
			
			return $this->hasMany(Promotion::class);
		}
		
		public function images() {
			
			return $this->hasMany(Image::class);
		}
		
		public function upgrades() {
			
			return $this->hasMany(Upgrade::class);
		}
		
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		public function messages() {
			
			return $this->hasMany(Message::class);
		}
		
		public function reservedDays() {
			
			return $this->hasMany(ReservedDay::class);
		}
		
		public function bookings() {
			
			return $this->hasMany(Booking::class);
		}
		
		public static function promoted($item_count) {
			
			return self::where('is_showed', 1)
			  ->whereHas(
				'promotions', function ($query) {
				  
				  $query->where('start_at', '<=', Carbon::now())->where('end_at', '>=', Carbon::now());
			  })
			  ->take($item_count)->get();
		}
	}
