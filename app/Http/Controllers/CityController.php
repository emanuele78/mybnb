<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	
	class CityController extends Controller {
		
		public function index() {
			$rawData = \Config::get('cities');
			$cities = [];
			foreach ($rawData as $index => $data) {
				$cities[] = [
				  'name' => $data['provincia'],
				  'code' => $index
				];
			}
			return response()->json($cities, 200);
		}
		
	}
