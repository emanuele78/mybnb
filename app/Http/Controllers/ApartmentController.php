<?php
	
	namespace App\Http\Controllers;
	
	use App\Constants;
	use App\Token;
	use Illuminate\Http\Request;
	
	//	use App\Traits\TokenTrait;
	
	class ApartmentController extends Controller {
		
		//		use TokenTrait;
		
		//		protected $tokenRepo;
		
		//		public function __construct(TokenRepoInterface $tokenRepo) {
		//			$this->tokenRepo = $tokenRepo;
		//		}
		
		//		function cities() {
		//			$rawData = \Config::get('cities');
		//			$cities = [];
		//			foreach ($rawData as $index => $data) {
		//				$cities[] = [
		//				  'name' => $data['provincia'],
		//				  'code' => $index
		//				];
		//			}
		//			return response()->json($cities, 200);
		//		}
		
		public function index() {
			$token_key = config('project.token_key');
			$showTokenBanner = session()->has($token_key) ? Token::isValid($token_key) : true;
			//todo send promo apartments and city links
			return view('layouts.index')->withShowTokenBanner($showTokenBanner);
		}
		
		//		//todo il token è solo da verificare in sessione
		//		private function showBanner(Request $request): bool {
		//			$user_token = $this->getTokenFromRequest($request);
		//			if ($user_token == null) {
		//				return true;
		//			}
		//			switch ($this->tokenRepo->checkToken($user_token)) {
		//				case Constants::VALID_TOKEN:
		//					return false;
		//				case Constants::FRESH_TOKEN:
		//					$this->saveTokenInSession($user_token);
		//					return false;
		//				default:
		//					return true;
		//			}
		//		}
		//
		//		//todo il token è solo da verificare in sessione
		//		public function getTokenFromRequest(Request $request): ?string {
		//			$token_key = config('project.token_key');
		//			if ($request->has($token_key)) {
		//				//request has url encoded token
		//				return $request->get($token_key);
		//			} elseif ($request->session()->has($token_key)) {
		//				//session has token
		//				return $request->session()->get($token_key);
		//			} else {
		//				//token not found in request
		//				return null;
		//			}
		//		}
		//
		//		//todo il salvataggio del token va fatto in altro controller
		//		private function saveTokenInSession($token): void {
		//			$token_key = config('project.token_key');
		//			session([$token_key => $token]);
		//		}
		//
		//		public function search(Request $request) {
		//			return view('layouts.search_results');
		//		}
		
	}
