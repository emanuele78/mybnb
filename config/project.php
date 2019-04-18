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
	  'notify_user_creation' => env('NOTIFY_USER_CREATION', false),
	  'use_test_recipient_for_admin' => env('USE_TEST_RECIPIENT_FOR_ADMIN', false),
	  'tomtom_api_key' => env('TOMTOM_API_KEY'),
	  'braintree' => [
		'environment' => env('ENVIRONMENT', null),
		'merchantId' => env('MERCHANT_ID', null),
		'publicKey' => env('PUBLIC_KEY', null),
		'privateKey' => env('PRIVATE_KEY', null)
	  ],
	  'pending_booking_max_life' => env('PENDING_BOOKING_MAX_LIFE'),
	];
