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
		  Route::get('/conversazioni', 'ApartmentThreadController@index')->name('message_dashboard');
		  //show thread
		  Route::get('/conversazioni/conversazione', 'ApartmentThreadController@show')->name('show_thread');
	  }
	);
	
	/* these routes are not subject to token limitations */
	//show the main index page
	Route::get('/', 'ApartmentController@index')->name('home');
	//activate the token
	Route::patch('/tokens/{token}', 'TokenController@update')->name('activate-token');
	
	Route::get(
	  '/test', function () {
		
		//only user apartments with messages
		$user = App\User::find(1);
		//		$apartmentsWithMessages = $user->apartments()->has('messages')->with('messages')->orderBy('title')->get();
		//		$results = [];
		//		foreach ($apartmentsWithMessages as $key => $apartmentsWithMessage) {
		//			$results[] = [
		//			  'slug' => $apartmentsWithMessage->slug,
		//			  'image' => $apartmentsWithMessage->main_image,
		//			  'title' => $apartmentsWithMessage->title,
		//			];
		//			$messages = [];
		//			$unreaded_messages = false;
		//			foreach ($apartmentsWithMessage->messages as $key1 => $message) {
		//				//only messages visible for everyone or current user
		//				if ($message->visible_for == null || $message->visible_for == $user->id) {
		//					//only messages sent by other users
		//					if ($user->nickname != $message->sender_id) {
		//						$index = array_search($message->sender_id, array_column($messages, 'sender'));
		//						if ($index === false) {
		//							$messages[] = ['sender' => $message->sender_id, 'unreaded' => $message->unreaded];
		//						} else {
		//							$messages[$index]['unreaded'] = $messages[$index]['unreaded'] ?: $message->unreaded;
		//						}
		//					}
		//					$unreaded_messages = $messages[$index]['unreaded'] ? true : $unreaded_messages;
		//				}
		//			}
		//			if (empty($messages)) {
		//				unset($results[$key]);
		//			} else {
		//				$results[$key]['messages'] = $messages;
		//				$results[$key]['unreaded_messages'] = $unreaded_messages;
		//			}
		//		}
		//		return $results;
		
		//appartamento corrente
		return \App\Message::where('apartment_id', 9)->whereHas(
		  'apartment.user', function ($query) {
			
			//di cui l'utente corrente è proprietario
			$query->where('id', 1);
		})->where(
		  function ($query) {
			  
		  	//esiste questo utente con cui ha scambiato messaggi
			  $query->where('sender_id', 8)->orWhere('recipient_id', 8);
		  })->get()->count();
	});