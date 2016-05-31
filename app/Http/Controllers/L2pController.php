<?php

namespace App\Http\Controllers;

use \App\Services\L2pRequestManager;

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
        $response = $this->requestManager->executeRequest($method, $uri, ['query' => $query], 'https://www3.elearning.rwth-aachen.de/_vti_bin/L2PServices/api.svc/v1/');
        return json_decode($response['body'], true);	            
    }
}
