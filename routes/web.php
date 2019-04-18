<?php
	
	Route::namespace('Auth')->middleware('check_token')->group(
	  function () {
		  
		  Route::post('/logout', 'LoginController@logout')->name('logout');
		  Route::post('/registration', 'RegisterController@register')->name('do_registration');
		  Route::post('/login', 'LoginController@login');
		  Route::get('/login', 'LoginController@showLoginForm')->name('login');
		  Route::get('/registrazione', 'RegisterController@showRegistrationForm')->name('register');
	  });
	
	//if the app token is not valid, user can't access the following uri
	Route::middleware('check_token')->group(
	  function () {
		  
		  Route::get('/ricerca', 'ApartmentController@search')->name('search');
		  Route::get('/appartamenti/{apartment}', 'ApartmentController@show')->name('show');
		  Route::get('/appartamenti/{apartment}/prenota', 'BookingController@create')->name('booking');
		  Route::post('/appartamenti/{apartment}/pagamento', 'BookingController@store')->name('payment');
		  Route::get('/clienti/registrazione', 'CustomerController@create')->name('register_customer');
		  Route::post('/clienti/registrazione', 'CustomerController@store')->name('save_customer');
	  }
	);
	
	/* these routes are not subject to token limitations */
	
	Route::get('/', 'ApartmentController@index')->name('home');
	
//	Route::get('/tokens/{token}', 'TokenController@update')->name('activate-token');
	
	Route::patch('/tokens/{token}', 'TokenController@update')->name('activate-token');

	
	