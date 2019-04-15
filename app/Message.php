<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Message extends Model {
		
		protected $guarded = ['id', 'created_at'];
		protected $with = ['apartment', 'user'];
		
		public function user() {
			
			return $this->belongsTo(User::class);
		}
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		public static function add($data) {
			unset($data['recipient_id']);
			$data['updated_at'] = null;
			Message::create($data);
		}
		
		public function setApartmentIdAttribute($value) {
			
			$this->attributes['apartment_id'] = Apartment::where('slug', $value)->first()->id;
		}
		
		public function setUserIdAttribute($value) {
			
			$this->attributes['user_id'] = User::where('nickname', $value)->first()->id;
		}
	}
