<?php
	
	namespace App\Http\Controllers\Auth;
	
	use App\User;
	use App\Http\Controllers\Controller;
	use Carbon\Carbon;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Foundation\Auth\RegistersUsers;
	
	class RegisterController extends Controller {
		
		/*
		|--------------------------------------------------------------------------
		| Register Controller
		|--------------------------------------------------------------------------
		|
		| This controller handles the registration of new users as well as their
		| validation and creation. By default this controller uses a trait to
		| provide this functionality without requiring any additional code.
		|
		*/
		
		use RegistersUsers;
		
		/**
		 * Where to redirect users after registration.
		 *
		 * @var string
		 */
		protected $redirectTo = '/';
		
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct() {
			
			$this->middleware('guest');
		}
		
		/**
		 * Get a validator for an incoming registration request.
		 *
		 * @param  array $data
		 * @return \Illuminate\Contracts\Validation\Validator
		 */
		protected function validator(array $data) {
			
			return Validator::make(
			  $data, [
			  'nickname' => ['required', 'string', 'max:255', 'unique:users'],
			  'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			  'password' => ['required', 'string', 'min:5'],
			  'date_of_birth' => ['bail', 'required', 'date', function ($attribute, $value, $fail) {
				  
				  $user_birthday = Carbon::createFromFormat('d-m-Y', $value);
				  if (Carbon::now()->addYears(-18)->lessThan($user_birthday)) {
					  $fail('Devi essere maggiorenne per diventare nostro cliente');
				  }
			  }],
			]);
		}
		
		/**
		 * Create a new user instance after a valid registration.
		 *
		 * @param  array $data
		 * @return \App\User
		 */
		protected function create(array $data) {
			
			return User::create(
			  [
				'nickname' => $data['nickname'],
				'email' => $data['email'],
				'date_of_birth' => Carbon::createFromFormat('d-m-Y', $data['date_of_birth']),
				'password' => Hash::make($data['password']),
			  ]);
		}
	}
