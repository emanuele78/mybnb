<?php
	
	namespace App\Http\Middleware;
	
	use App\Token;
	use Carbon\Carbon;
	use Closure;
	
	class CheckToken {
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Closure $next
		 * @return mixed
		 */
		public function handle($request, Closure $next) {
			$token_key = config('project.token_key');
			if ($request->session()->has($token_key)) {
				//check if token is expiried
				$token = $request->session()->get($token_key);
				if (Token::where('token', $token)->where('expiration', '>', Carbon::now())->first() == null) {
					return redirect()->route('home');
				}
				return $next($request);
			}
			return redirect()->route('home');
		}
	}
