<?php
	
	Route::get(
	  '/', function () {
		return view('welcome');
	});
	
	Route::namespace('Auth')->group(
	  function () {
		  Route::post('/registration', 'RegisterController@register');
		  Route::post('/login', 'LoginController@login');
		  Route::post('/logout', 'LoginController@logout')->middleware('auth')->name('logout');
		  Route::get('/login', 'LoginController@showLoginForm')->name('login');
		  Route::get('/registrazione', 'RegisterController@showRegistrationForm')->name('register');
	  });
