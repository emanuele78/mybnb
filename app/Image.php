<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Storage;
	
	class Image extends Model {
		
		protected $fillable = ['name', 'apartment_id'];
		
		/**
		 * Eloquent relationship
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function apartment() {
			
			return $this->belongsTo(Apartment::class);
		}
		
		/**
		 * Store additionaly images for an apartment
		 *
		 * @param $apartment_id
		 * @param $other_images
		 */
		public static function storeAdditional($apartment_id, $other_images) {
			
			foreach ($other_images as $other_image) {
				$name = self::storeFile($other_image);
				self::create(['apartment_id' => $apartment_id, 'name' => $name]);
			}
			
		}
		
		/**
		 * Store an image on disk
		 *
		 * @param $image_file
		 * @return string
		 */
		public static function storeFile($image_file): string {
			
			$filePath = Storage::disk('users_uploads')->put('apartments', $image_file);
			return basename($filePath);
		}
	}
