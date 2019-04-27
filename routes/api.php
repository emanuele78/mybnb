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
		  Route::post('/apartments/{apartment}/messages', 'Api\MessageController@store');
		  //list messages received for own apartments and sent for other apartments (dashboard)
		  Route::get('/messages', 'Api\ApartmentThreadController@index');
		  //get token for the transaction
		  Route::get('/payments/token', 'PaymentTokenController@show');
		  //add new transaction
		  Route::post('/booking/payment', 'BookingPaymentController@store');
		  //get all messages for a thread
		  Route::get('/apartments/threads/{thread}', 'Api\ApartmentThreadController@show');
		  //store a message sent from a thread
		  Route::post('/apartments/threads/{thread}', 'Api\ApartmentThreadController@store');
	  });
	