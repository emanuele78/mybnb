<?php
	
	namespace App\Http\Controllers\Api;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use App\Traits\TokenTrait;
	
	class TokenController extends Controller {
		
		use TokenTrait;
		
	}
