<?php
	
	namespace App\Http\Middleware;
	
	use App\Token;
	use Closure;
	use Illuminate\Support\Facades\Cookie;
	
	class CheckToken {
		
		/**
		 * Sessions without token can visit only home page
		 *
		 * @param $request
		 * @param Closure $next
		 * @return \Illuminate\Http\RedirectResponse|mixed
		 */
		public function handle($request, Closure $next) {
			
			if (config('project.bypass_token')) {
				return $next($request);
			}
			$token_key = config('project.token_key');
			if (Cookie::has($token_key)) {
				if (Token::isValid(Cookie::get($token_key))) {
					return $next($request);
				}
				return redirect('/');
			}
			return redirect('/');
		}
	}
