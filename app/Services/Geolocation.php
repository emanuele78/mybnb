<?php
	
	namespace App\Services;
	
	use GuzzleHttp\Client;
	
	class Geolocation {
		
		private $api_key;
		private $client;
		
		public function __construct($api_key) {
			
			$this->api_key = $api_key;
			$this->client = new Client(
			  [
				'base_uri' => 'https://api.tomtom.com'
			  ]);
		}
		
		public function getMap($lat, $lon) {
			
			$center = "$lon,$lat";
			$uri = '/map/1/staticimage';
			try {
				$response = $this->client->request(
				  'GET',
				  $uri, [
					'query' => [
					  'layer' => 'basic',
					  'style' => 'main',
					  'format' => 'png',
					  'zoom' => 16,
					  'center' => $center,
					  'width' => 512,
					  'height' => 512,
					  'view' => 'Unified',
					  'key' => $this->api_key
					],
					'headers' => [
					  'Accept' => '*/*'
					]
				  ]);
			} catch (\Exception $e) {
				return response('fail', 400);
			}
			$data = $response->getBody()->getContents();
			return base64_encode($data);
		}
		
		public function getAddress($lat, $lon) {
			
			$address = [
			  'response' => false,
			  'streetName' => '',
			  'municipality' => '',
			  'postal_code' => '',
			  'province' => ''
			];
			try {
				$uri = "/search/2/reverseGeocode/$lat,$lon.json";
				$response = $this->client->request(
				  'GET',
				  $uri, [
					'query' => [
					  'key' => $this->api_key
					],
					'headers' => [
					  'Accept' => '*/*'
					]
				  ]);
				$decodedJson = json_decode($response->getBody()->getContents(), true);
				if (array_key_exists('streetName', $decodedJson['addresses'][0]['address'])) {
					$address['streetName'] = $decodedJson['addresses'][0]['address']['streetName'];
				}
				if (array_key_exists('municipality', $decodedJson['addresses'][0]['address'])) {
					$address['municipality'] = $decodedJson['addresses'][0]['address']['municipality'];
				}
				if (array_key_exists('postalCode', $decodedJson['addresses'][0]['address'])) {
					$address['postal_code'] = $decodedJson['addresses'][0]['address']['postalCode'];
				}
				if (array_key_exists('countrySecondarySubdivision', $decodedJson['addresses'][0]['address'])) {
					$address['province'] = $decodedJson['addresses'][0]['address']['countrySecondarySubdivision'];
				}
				$address['response'] = true;
				return $address;
			} catch (\Exception $e) {
				return $address;
			}
		}
	}