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
	  }
	);
	
	/* NEW ROUTES START HERE */
	//1
	Route::get('/', 'ApartmentController@index')->name('home');
	//2
	Route::get('/tokens/{token}', 'TokenController@update')->name('activate-token');
	//3
	Route::patch('/tokens/{token}', 'TokenController@update')->name('activate-token');
	