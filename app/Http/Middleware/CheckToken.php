<?php
	
	namespace App\Http\Middleware;
	
	use App\Services\TokenUtil;
	use Closure;
	
	class CheckToken {
		
		private $tokenUtil;
		
		public function __construct(TokenUtil $tokenUtil) {
			
			$this->tokenUtil = $tokenUtil;
		}
		
		/**
		 * @param $request
		 * @param Closure $next
		 * @param TokenUtil $tokenUtil
		 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
		 */
		public function handle($request, Closure $next) {
			
			if ($this->tokenUtil->is_allowed()) {
				return $next($request);
			}
			return redirect('/');
		}
	}
