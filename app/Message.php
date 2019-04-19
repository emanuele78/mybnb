<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	//todo need revision
	class Message extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		public function thread() {
			
			return $this->belongsTo(Thread::class);
		}
		
		public static function add($data) {
			
			Message::create($data);
		}
		
		public function setApartmentIdAttribute($value) {
			
			$this->attributes['apartment_id'] = Apartment::where('slug', $value)->first()->id;
		}
		
		public function setSenderUserIdAttribute($value) {
			
			$this->attributes['sender_user_id'] = User::where('nickname', $value)->first()->id;
		}
		
		public function setRecipientUserIdAttribute($value) {
			
			$this->attributes['recipient_user_id'] = User::where('nickname', $value)->first()->id;
		}
		
		public function sender() {
			
			return $this->belongsTo('App\User', 'sender_user_id', 'id');
		}
		
		public function recipient() {
			
			return $this->belongsTo('App\User', 'recipient_user_id', 'id');
		}
	}
