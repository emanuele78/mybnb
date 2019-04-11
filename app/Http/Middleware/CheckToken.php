<?php
	
	namespace App\Http\Middleware;
	
	use App\Constants;
	use App\Repositories\Interfaces\TokenRepoInterface;
	use Closure;
	
	class CheckToken {

		protected $tokenRepo;
		
		public function __construct(TokenRepoInterface $tokenRepo) {
			$this->tokenRepo = $tokenRepo;
		}
		
		public function handle($request, Closure $next) {
			$token_key = config('project.token_key');
			if ($request->session()->has($token_key)) {
				//check if token is expired
				$user_token = $request->session()->get($token_key);
				if($this->tokenRepo->checkToken($user_token) == Constants::VALID_TOKEN){
					return $next($request);
				}
				return redirect()->route('home');
			}
			return redirect()->route('home');
		}
	}
