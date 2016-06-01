<?php

namespace App\Http\Controllers;

use Config;
use App\Services\L2pRequestManager;

/**
 * Description of MyController
 *
 * @author odgiiv
 */
class L2pController extends Controller {
    
    const GET = 'GET';    
    const POST = 'POST';
    const STATUS_FALSE = false;
    const STATUS_TRUE = true;
    
    protected $requestManager;
    protected $tokenManager;
    protected $defaultResponse;
    
    function __construct(L2pRequestManager $requestManager) {        
        $this->requestManager = $requestManager;        
        $this->defaultResponse = $this->jsonResponse(false, 'This is default response');
    }
    
    //TODO: Check response code
    protected function sendRequest($method, $uri, $query = []) {
        $response = $this->requestManager->executeRequest($method, $uri, ['query' => $query], Config::get('l2pconfig.api_url'), 6.0);                
        return json_decode($response['body'], true);	            
//        return $response['body'];
    }
    
    //return json response to client.
    protected function jsonResponse($status=false, $body = '') {
        return response()->json(['status' => $status, 'body' => $body]);
    }
}
