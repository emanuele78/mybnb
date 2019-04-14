<?php
	
	Route::namespace('Auth')->middleware('check_token')->group(
	  function () {
		  
		  Route::post('/registration', 'RegisterController@register');
		  Route::post('/login', 'LoginController@login');
		  Route::post('/logout', 'LoginController@logout')->middleware('auth')->name('logout');
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
	
	//todo to be deleted
	Route::view('/test', 'TokenController@store');