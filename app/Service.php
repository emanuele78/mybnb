<?php
	
	namespace App;
	
	use Cviebrock\EloquentSluggable\Sluggable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\DB;
	
	class Service extends Model {
		
		use Sluggable;
		
		protected $fillable = ['name'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
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
		
		/**
		 * Return a service by the slug
		 *
		 * @param $slug
		 * @return mixed
		 */
		public static function findBySlug($slug) {
			
			return Service::where('slug', $slug)->first();
		}
		
		/**
		 * Return all the services
		 *
		 * @return mixed
		 */
		public static function findAll() {
			
			return Service::orderBy('name')->get();
		}
		
		/**
		 * Create a new service
		 *
		 * @param $name
		 * @return Service
		 */
		public static function addNew($name): self {
			
			$service = new Service();
			$service->name = $name;
			$service->save();
			return $service;
		}
		
		/**
		 * Return all the services not selected for the given apartment
		 *
		 * @param $apartment_id
		 * @return array
		 */
		public static function notSelectedIn($apartment_id): array {
			
			return DB::table('services')->select('name', 'slug')->whereNotIn(
			  'id', function ($query) use ($apartment_id) {
				
				$query->select('service_id')->from('upgrades')->where('apartment_id', $apartment_id);
			})->get()->toArray();
		}
	}
