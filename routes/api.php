<?php
	
	use Illuminate\Http\Request;
	
	Route::middleware('auth:api')->get(
	  '/user', function (Request $request) {
		
		return $request->user();
	});
	
	Route::middleware('only_ajax')->group(
	  function () {
		  
		  //get the list of the cities
		  Route::get('/cities', 'CityController@index');
		  //create new token
		  Route::post('/tokens', 'TokenController@store');
		  //get availability for a search
		  Route::get('/apartments/{apartment}/booking', 'ApartmentAvailabilityController@show');
		  //show the map fo an apartment
		  Route::get('/apartments/{apartment}/map', 'ApartmentMapController@show');
		  //show the address of an apartment
		  Route::get('/apartments/{apartment}/address', 'ApartmentAddressController@show');
	  }
	);
	
	Route::middleware('auth:api')->group(
	  function () {
		  
		  //add new message
		  Route::post('/messages', 'MessageController@store');
		  //list user message threads
		  Route::get('/messages', 'Api\ThreadController@index');
		  //get token for the transaction
		  Route::get('/payments/token', 'PaymentTokenController@show');
		  //add new transaction
		  Route::post('/booking/payment', 'BookingPaymentController@store');
	  });
	
