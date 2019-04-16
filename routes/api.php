<?php
	
	use Illuminate\Http\Request;
	
	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| is assigned the "api" middleware group. Enjoy building your API!
	|
	*/
	
	Route::middleware('auth:api')->get(
	  '/user', function (Request $request) {
		
		return $request->user();
	});
	
	Route::middleware('only_ajax')->group(
	  function () {
		  
		  Route::get('/cities', 'CityController@index');
		  Route::post('/tokens', 'TokenController@store');
		  Route::get('/apartments/{apartment}/booking', 'BookingController@index');
	  }
	);
	
	Route::middleware('auth:api')->group(
	  function () {
		  
		  Route::post('/messages', 'MessageController@store');
		  
	  });