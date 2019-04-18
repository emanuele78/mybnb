<?php
	
	namespace App;
	
	use Cviebrock\EloquentSluggable\Sluggable;
	use Illuminate\Database\Eloquent\Model;
	
	class Service extends Model {
		
		use Sluggable;
		
		protected $fillable = ['name'];
		
		public function upgrades() {
			
			return $this->hasMany(Upgrade::class);
		}
		
		/**
		 * Return the sluggable configuration array for this model.
		 *
		 * @return array
		 */
		public function sluggable() {
			
			return [
			  'slug' => [
				'source' => 'name'
			  ]
			];
		}
		
		public static function findBySlug($slug){
			return Service::where('slug',$slug)->first();
		}
	}
