<?php
	
	use Illuminate\Http\Request;
	
	Route::middleware('auth:api')->get(
	  '/user', function (Request $request) {
		
		return $request->user();
	});
	
	Route::middleware('only_ajax')->group(
	  function () {
		  
		  //create new token
		  Route::post('/tokens', 'TokenController@store');
		  //get availability for a search
		  Route::get('/apartments/{apartment}/booking', 'ApartmentAvailabilityController@show');
		  //show the map fo an apartment
		  Route::get('/apartments/{apartment}/map', 'ApartmentMapController@show');
		  //show the address of an apartment
		  Route::get('/apartments/{apartment}/address', 'ApartmentAddressController@show');
		  //apartment search
		  Route::get('/apartments/search', 'ApartmentSearchController@show');
	  }
	);
	
	Route::middleware('auth:api')->group(
	  function () {
		  
		  //apartments dashboard
		  Route::get('/apartments', 'Api\ApartmentController@index');
		  //edit apartment
		  Route::patch('/apartments/{apartment}/visibility', 'Api\ApartmentController@update');
		  //delete apartment
		  Route::delete('/apartments/{apartment}', 'Api\ApartmentController@destroy');
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
		  //store new message for a thread
		  Route::post('/apartments/threads/{thread}', 'Api\ApartmentThreadController@store');
		  //delete a thread
		  Route::delete('/apartments/threads/{thread}', 'Api\ApartmentThreadController@destroy');
		  //get availability for a search with passport auth
		  Route::get('/auth/apartments/{apartment}/booking', 'ApartmentAvailabilityController@show');
		  //get a list of all bookings
		  Route::get('/bookings', 'Api\BookingController@index');
		  //address search
		  Route::get('/geo/addresses', 'Api\GeolocationController@index');
		  //map from coordinates
		  Route::get('/geo/maps/map', 'Api\GeolocationController@show');
		  //check if chosen promotion is valid
		  Route::get('/auth/apartments/{apartment}/promotions/check', 'ApartmentPromotionController@index');
		  //pay and store promotion for apartment
		  Route::post('/auth/apartments/{apartment}/promotions/', 'ApartmentPromotionController@store');
	  });
	