<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Message extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
//		protected $with = ['apartment', 'user'];
		
		public function user() {
			
			return $this->belongsTo('App\User', 'sender_user_id');
		}
		
		public function apartment() {
			
			return $this->belongsTo('App\Apartment','recipient_apartment_id');
		}
		
		public static function add($data) {
			Message::create($data);
		}
		
		public function setRecipientApartmentIdAttribute($value) {
			
			$this->attributes['recipient_apartment_id'] = Apartment::where('slug', $value)->first()->id;
		}
		
		public function setSenderUserIdAttribute($value) {
			
			$this->attributes['sender_user_id'] = User::where('nickname', $value)->first()->id;
		}
		
	}
