<?php

namespace App\Http\Controllers;

use Config;
use App\Services\L2pRequestManager;
use Auth;


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
                
    public function sendRestRequest($method, $uri, $query = []) {        
        $query += ['accessToken' => Auth::user()->access_token];
        $response = $this->requestManager->executeRequest($method, $uri, ['query' => $query], Config::get('l2pconfig.api_url'), 6.0);                
        if($response['code'] != 200) {
            //TODO: log error
            return $this->jsonResponse(self::STATUS_FALSE, $response['reason_phrase']);            
        }
        return json_decode($response['body'], true);	            
    }
    
    //return json response to client.
    protected function jsonResponse($status=false, $body = '') {
        return response()->json(['Status' => $status, 'Body' => $body]);
    }
    
    protected function addParamsReq2Req($request, $params) {
        $returnArray = array();
        foreach ($params as $param) {                        
            if($request->has($param)) {
                $returnArray += [$param => $request->input($param)];
            }
        }
        return $returnArray;
    }
}
