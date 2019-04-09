<?php
	
	return [
	  
	  'use_test_recipient' => env('USE_TEST_RECIPIENT', true),
	  'test_recipient_mail' => env('TEST_RECIPIENT_MAIL', 'john@doe.com'),
	  'token_key' => env('APP_TOKE_KEY'),
	  'token_expiration_time' => env('TOKEN_EXPIRATION_TIME', 20),
	
	];
