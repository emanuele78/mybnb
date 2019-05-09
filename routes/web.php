<?php
	
	//if the app token is not valid, user can't access the following uri
	Route::namespace('Auth')->middleware('check_token')->group(
	  function () {
		  
		  //logout action
		  Route::post('/logout', 'LoginController@logout')->name('logout');
		  //register action
		  Route::post('/registration', 'RegisterController@register')->name('do_registration');
		  //login action
		  Route::post('/login', 'LoginController@login');
		  //show login form
		  Route::get('/login', 'LoginController@showLoginForm')->name('login');
		  //show registration form
		  Route::get('/registrazione', 'RegisterController@showRegistrationForm')->name('register');
	  });
	
	//if the app token is not valid, user can't access the following uri
	Route::middleware('check_token')->group(
	  function () {
		  
		  //apartments dashboard
		  Route::get('/appartamenti', 'ApartmentController@index')->name('apartments_dashboard');
		  //new apartment form
		  Route::get('/appartamenti/nuovo', 'ApartmentController@create')->name('new_apartment');
		  //store the newly created apartment
		  Route::post('/appartamenti/nuovo', 'ApartmentController@store')->name('save_apartment');
		  //update apartment
		  Route::put('/appartamenti/{apartment}', 'ApartmentController@update')->name('update_apartment');
		  //edit apartment form
		  Route::get('/appartamenti/{apartment?}/modifica', 'ApartmentController@edit')->name('edit_apartment');
		  //show the apartment show view
		  Route::get('/appartamenti/{apartment?}', 'ApartmentController@show')->name('show');
		  //show the apartment booking form
		  Route::get('/appartamenti/{apartment}/prenota', 'BookingController@create')->name('booking');
		  //promote
		  Route::get('/appartamenti/{apartment}/promuovi', 'ApartmentPromotionController@create')->name('promote');
		  //create pending booking
		  Route::post('/appartamenti/{apartment}/pagamento', 'BookingController@store')->name('payment');
		  //show the registration form for the customer
		  Route::get('/clienti/registrazione', 'CustomerController@create')->name('register_customer');
		  //add new customer
		  Route::post('/clienti/registrazione', 'CustomerController@store')->name('save_customer');
		  //show messages dashboard
		  Route::get('/conversazioni', 'ApartmentThreadController@index')->name('message_dashboard');
		  //show a single thread
		  Route::get('/conversazioni/{thread?}', 'ApartmentThreadController@show')->name('show_thread');
		  //show all the bookings
		  Route::get('/prenotazioni', 'BookingController@index')->name('show_bookings');
		  //resume a pending booking
		  Route::get('/prenotazioni/{booking}/modifica', 'BookingController@edit')->name('resume_booking');
		  //download a booking receipt
		  Route::get('/prenotazioni/ricevute/{booking?}', 'BookingPaymentController@show')->name('show_receipt');
		  //download a booking receipt
		  Route::get('/promozioni/ricevute/{promotion}', 'ApartmentPromotionController@show')->name('show_promo_receipt');
		  //search page
		  Route::get('/ricerca', 'ApartmentSearchController@create')->name('search');
	  }
	);
	
	/* these routes are not subject to token limitations */
	//faq page - static
	Route::view('/faq', 'layouts.faq')->name('show_faq');
	//privacy policy
	Route::view('/privacy', 'layouts.privacy')->name('show_privacy');
	//show the main index page
	Route::get('/', 'LandingPageController@index')->name('home');
	//activate the token
	Route::patch('/tokens/{token}', 'TokenController@update')->name('activate-token');
	
	//todo to be deleted - only for debugging purposes
	Route::get('/test', 'ApartmentSearchController@test');
	Route::get(
	  '/cipria', function () {
		
		return \App\Apartment::join('promotions', 'apartments.id', '=', 'promotions.apartment_id')
		  ->join('promotion_plans', 'promotions.promotion_plan_id', '=', 'promotion_plans.id')
		  ->where('apartments.is_showed', true)
		  ->where('promotions.start_at', '<=', \Carbon\Carbon::now())
		  ->where('promotions.end_at', '>=', \Carbon\Carbon::now())
		  ->orderBy('promotions.created_at', 'desc')
		  ->select(['apartments.id', 'apartments.slug', 'apartments.main_image', 'apartments.people_count', 'apartments.room_count', 'apartments.title', 'promotions.created_at', 'promotion_plans.card_type'])
		  ->take(20)->get();
	});
	Route::get(
	  '/casa', function () {
		
		$userData = [
		  'city_code' => 1,
		  'check_in' => '18-05-2029',
		  'check_out' => '20-05-2029',
		  'people_count' => 2,
		  'distance_radius' => 100,
		  'price_range' => [10, 150],
		  'services' => [],
		  'order_by' => 'square_meters'
		];
		return \App\Apartment::search($userData);
	});