<?php
	
	return [
	  
	  'use_test_recipient' => env('USE_TEST_RECIPIENT', true),
	  'test_recipient_mail' => env('TEST_RECIPIENT_MAIL'),
	  'token_key' => env('APP_TOKEN_KEY'),
	  'token_expiration_time' => env('TOKEN_EXPIRATION_TIME', 20),
	  'token_email_from_email' => env('TOKEN_EMAIL_FROM_EMAIL'),
	  'token_email_from_name' => env('TOKEN_EMAIL_FROM_NAME'),
	  'admin_email' => env('ADMIN_EMAIL'),
	  'notify_token_request' => env('NOTIFY_TOKEN_REQUEST', false),
	  'notify_token_activation' => env('NOTIFY_TOKEN_ACTIVATION', false),
	  'token_debug_code' => env('TOKEN_DEBUG_CODE'),
	  'bypass_token' => env('BYPASS_TOKEN', false)
	];
