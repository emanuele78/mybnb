<?php
	
	namespace App\Http\Middleware;
	
	use Carbon\Carbon;
	use Closure;
	use Illuminate\Support\Facades\DB;
	
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
				if (DB::table('tokens')->where('token', $token)->where('expiration', '>', Carbon::now())->get()->first() == null) {
					return redirect()->route('home');
				}
				return $next($request);
			}
			return redirect()->route('home');
		}
	}
