<?php
	
	namespace App\Providers;
	
	use App\Services\Geolocation;
	use App\Services\TokenUtil;
	use Illuminate\Support\ServiceProvider;
	
	class AppServiceProvider extends ServiceProvider {
		
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register() {
			//
		}
		
		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot() {
			
			$this->app->singleton(
			  Geolocation::class, function () {
				
				return new Geolocation(config('project.tomtom_api_key'));
			});
			
			$this->app->singleton(
			  TokenUtil::class, function () {
				
				return new TokenUtil(config('project.token_key'));
			});
		}
	}
