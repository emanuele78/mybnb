<?php
	
	namespace App\Http\Controllers\Auth;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Foundation\Auth\AuthenticatesUsers;
	
	class LoginController extends Controller {
		
		use AuthenticatesUsers;
		
		/**
		 * Where to redirect users after login.
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
			
			$this->middleware('guest')->except('logout');
		}
		
		//todo need revision
		public function redirectPath() {
			
			//			if (method_exists($this, 'redirectTo')) {
			//				return $this->redirectTo();
			//			}
			//
			//			return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
			
			return '/faq';
		}
	}
