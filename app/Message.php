<?php
	
	namespace App;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	
	class Message extends Model {
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * Create new message with given data
		 *
		 * @param $data
		 */
		public static function add($data) {
			
			Message::create($data);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function thread() {
			
			return $this->belongsTo(Thread::class);
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function sender() {
			
			return $this->belongsTo('App\User', 'sender_id', 'id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function recipient() {
			
			return $this->belongsTo('App\User', 'recipient_id', 'id');
		}
		
		/**
		 * Casting attribute to local timezone
		 *
		 * @param $value
		 * @return string
		 */
		public function getUpdatedAtAttribute($value) {
			
			return $this->getCreatedAtAttribute($value);
		}
		
		/**
		 * Casting attribute to local timezone
		 *
		 * @param $value
		 * @return string
		 */
		public function getCreatedAtAttribute($value) {
			
			$d = Carbon::createFromFormat('Y-m-d H:i:s', $value);
			$d->setTimezone('Europe/Rome');
			return $d->format('d/m/Y H:i:s');
		}
		
	}
