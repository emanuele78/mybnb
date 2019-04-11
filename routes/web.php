<?php
	
	Route::namespace('Auth')->group(
	  function () {
		  Route::post('/registration', 'RegisterController@register');
		  Route::post('/login', 'LoginController@login');
		  Route::post('/logout', 'LoginController@logout')->middleware('auth')->name('logout');
		  Route::get('/login', 'LoginController@showLoginForm')->name('login');
		  Route::get('/registrazione', 'RegisterController@showRegistrationForm')->name('register');
	  });
	
	
//	Route::middleware('check_token')->group(
//	  function () {
//		  Route::get('/ricerca', 'ApartmentController@search')->name('search');
//	  }
//	);
	
//	Route::get('/convalida-token', 'Api\TokenController@activateToken')->name('activate-token');
	
	
	
	/* NEW ROUTES START HERE */
	
	Route::get('/', 'ApartmentController@index')->name('home');