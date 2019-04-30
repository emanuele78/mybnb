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
		  
		  //show the apartment show view
		  Route::get('/appartamenti/{apartment?}', 'ApartmentController@show')->name('show');
		  //show the apartment booking form
		  Route::get('/appartamenti/{apartment}/prenota', 'BookingController@create')->name('booking');
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
		  //download a receipt
		  Route::get('/prenotazioni/ricevute/{booking?}', 'BookingPaymentController@show')->name('show_receipt');
	  }
	);
	
	/* these routes are not subject to token limitations */
	//show the main index page
	Route::get('/', 'LandingPageController@index')->name('home');
	//activate the token
	Route::patch('/tokens/{token}', 'TokenController@update')->name('activate-token');
	
	//todo to be deleted - only for debugging purposes
	Route::get('/test', 'BookingPaymentController@show');
