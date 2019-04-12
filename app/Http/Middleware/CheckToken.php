<?php
	
	namespace App\Http\Middleware;
	
	use App\Token;
	use Closure;
	
	class CheckToken {
		
		/**
		 * Sessions without token can visit only home page
		 *
		 * @param $request
		 * @param Closure $next
		 * @return \Illuminate\Http\RedirectResponse|mixed
		 */
		public function handle($request, Closure $next) {
			
			$token_key = config('project.token_key');
			if ($request->session()->has($token_key)) {
				//check token expiration
				if (Token::isValid($request->session()->get($token_key))) {
					return $next($request);
				}
				return redirect()->route('home');
			}
			return redirect()->route('home');
		}
	}
