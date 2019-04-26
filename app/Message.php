<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	
	//todo need revision
	class Message extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		//		protected $visible = ['unreaded', 'sender', 'apartment', 'sender_id', 'recipient_id'];
		protected $hidden = ['id', 'apartment_id'];
		
		public static function add($data) {
			
			Message::create($data);
		}
		
		public function setApartmentIdAttribute($value) {
			
			$this->attributes['apartment_id'] = Apartment::where('slug', $value)->first()->id;
		}
		
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		public function setSenderIdAttribute($value) {
			
			$this->attributes['sender_id'] = User::where('nickname', $value)->first()->id;
		}
		
		public function setRecipientIdAttribute($value) {
			
			$this->attributes['recipient_id'] = User::where('nickname', $value)->first()->id;
		}
		
		public function sender() {
			
			return $this->belongsTo('App\User', 'sender_id', 'id');
		}
		
		public function recipient() {
			
			return $this->belongsTo('App\User', 'recipient_id', 'id');
		}
		
		public function getSenderIdAttribute($value) {
			
			return User::find($value)->nickname;
		}
		
		public function getRecipientIdAttribute($value) {
			
			return User::find($value)->nickname;
		}
		
		public function getUpdatedAtAttribute($value) {
			
			return $this->getCreatedAtAttribute($value);
		}
		
		public function getCreatedAtAttribute($value) {
			
			$d = Carbon::createFromFormat('Y-m-d H:i:s', $value);
			$d->setTimezone('Europe/Rome');
			return $d->format('d/m/Y H:i:s');
		}
		
		public static function thread($apartment, $first_user, $second_user) {
			
			return Message::where('apartment_id', $apartment->id)->where(
			  function ($query) use ($first_user, $second_user) {
				  
				  $query->where('recipient_id', $first_user->id)
					->orWhere('recipient_id', $second_user->id);
			  })
			  ->where(
				function ($query) use ($first_user, $second_user) {
					
					$query->where('sender_id', $first_user->id)
					  ->orWhere('sender_id', $second_user->id);
				})
			  ->with('apartment.user')
			  ->orderBy('created_at')->get();
		}
		
		public static function threadExist($apartment_id, $apartment_owner_id, $other_user_id): bool {
			
			return \App\Message::where('apartment_id', $apartment_id)->whereHas(
			  'apartment.user', function ($query) use ($apartment_owner_id) {
				
				//where the owner is
				$query->where('id', $apartment_owner_id);
			})->where(
			  function ($query) use ($other_user_id) {
				  
				  //where exists a thread with
				  $query->where('sender_id', $other_user_id)->orWhere('recipient_id', $other_user_id);
			  })->get()->count();
		}
	}
