<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Thread extends Model {
		
		protected $fillable = ['started_by', 'apartment_id'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function startedBy() {
			
			return $this->belongsTo('App\User', 'started_by', 'id');
		}
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		public static function findOrCreate($apartment_id, $started_by) {
		    $thread = Thread::where('apartment_id', $apartment_id)->where('started_by'.$started_by)->first();
		}
	}
