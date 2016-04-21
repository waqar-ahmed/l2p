<?php

namespace App\Services;

use GuzzleHttp\Client;

class CourseManager
{

	private $client;
	private $tokenManager;

	function __construct()
	{
		$this->tokenManager = new TokenManager();
		$this->client = new Client(["base_uri" => 'https://www3.elearning.rwth-aachen.de/_vti_bin/L2PServices/api.svc/v1/', 'timeout'  => 6.0]);
	}

	public function getAllCourses()
	{
		//$response = $this->client->request('GET', 'viewAllCourseInfo', ['query' => 'accessToken=klllqu3cBbOh2ZB0rVrw4r1Jn5TyJnsXFZtsWKfOGua2fEUCSTlRi9Zlul6HrpwW']);
		$response = $this->client->request('GET', 'viewAllCourseInfo', ['query' => ['accessToken' => $this->tokenManager->getAccessToken()]]);
		return json_decode($response->getBody(), true);		
	}
        
        public function sendRestRequest($method, $uri, $query = []) {
            $query += ['accessToken' => $this->tokenManager->getAccessToken()];            
            $response = $this->client->request($method, $uri, ['query' => $query]);
            return json_decode($response->getBody(), true);		            
        }
}