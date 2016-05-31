<?php

namespace App\Http\Controllers;

use App\Services\L2pRequestManager;
use Config;

/**
 * Description of MyController
 *
 * @author odgiiv
 */
class L2pController extends Controller {
    
    CONST GET = 'GET';    
    private $requestManager;
    
    function __construct(L2pRequestManager $requestManager) {        
        $this->requestManager = $requestManager;
    }
    
    protected function sendRequest($method, $uri, $query = []) {
        $response = $this->requestManager->executeRequest($method, $uri, ['query' => $query], Config::get('l2pconfig.api_url'));
        return json_decode($response['body'], true);	            
    }
}
