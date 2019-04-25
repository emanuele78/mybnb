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
		  
		  //todo wip
		  Route::get('/ricerca', 'ApartmentController@search')->name('search');
		  //show the apartment show view
		  Route::get('/appartamenti/{apartment}', 'ApartmentController@show')->name('show');
		  //show the apartment booking form
		  Route::get('/appartamenti/{apartment}/prenota', 'BookingController@create')->name('booking');
		  //create pending booking
		  Route::post('/appartamenti/{apartment}/pagamento', 'BookingController@store')->name('payment');
		  //show the registration form for the customer
		  Route::get('/clienti/registrazione', 'CustomerController@create')->name('register_customer');
		  //add new customer
		  Route::post('/clienti/registrazione', 'CustomerController@store')->name('save_customer');
		  //show messages dashboard
		  Route::get('/conversazioni', 'MessageController@index')->name('message_dashboard');
		  //show thread
		  Route::get('/conversazioni/miei-appartamenti', 'ApartmentThreadController@show')->name('show_thread');
	  }
	);
	
	/* these routes are not subject to token limitations */
	//show the main index page
	Route::get('/', 'ApartmentController@index')->name('home');
	//activate the token
	Route::patch('/tokens/{token}', 'TokenController@update')->name('activate-token');
	
	Route::get(
	  '/test', function () {
		
		return App\Message::where('apartment_id', 16)->where(
		  function ($query) {
			  
			  $query->where('recipient_id', 9)
				->orWhere('recipient_id', 1);
		  })
		  ->where(
			function ($query) {
				
				$query->where('sender_id', 1)
				  ->orWhere('sender_id', 9);
			})
		  ->with('apartment.user')
		  ->orderBy('created_at')->get();
	});