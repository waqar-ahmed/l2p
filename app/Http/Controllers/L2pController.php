<?php

namespace App\Http\Controllers;

use App\Services\L2pRequestManager;
use Auth;
use Validator;


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
    protected $validations;
    
    function __construct(L2pRequestManager $requestManager) {        
        $this->requestManager = $requestManager;        
        $this->defaultResponse = $this->jsonResponse(false, 'This is default response');
    }
                
    public function sendRequest($method, $uri, $query = [], $data = [], $isJson = false) {                                        
        $query += ['accessToken' => Auth::user()->access_token];
        if($isJson) {
            $response = $this->requestManager->executeRequest($method, $uri, ['query' => $query, 'json' => $data]);                
        } else {
            $response = $this->requestManager->executeRequest($method, $uri, ['query' => $query, 'form_params' => $data]);                
        }        
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
    
    protected function addToModule($input, $uri, $uriQuery = [], $validations = []) {                
        if (empty($validations)) {
            if (!is_null($this->validations)) {
                $validations = $this->validations;
            }                   
        }        
        $validator = Validator::make($input, $validations);
        if ($validator->fails()) {
            return $this->jsonResponse(self::STATUS_FALSE, $validator->errors()->all());            
        }   
        return $this->sendRequest(self::POST, $uri, $uriQuery, true, $this->addParamsReq2Req($input, array_keys($this->validations)));        
    }
    
    protected function addParamsReq2Req($inputArray, $params) {
        $returnArray = array();
        foreach ($params as $param) {                        
            if(in_array($param, $inputArray)) {
                $returnArray += [$param => $inputArray[$param]];
            }
        }
        return $returnArray;
    }
    
    public function viewUserRole($cid) {
        return $this->sendRequest(self::GET, 'viewUserRole', ['cid'=>$cid]);
    }
    
    public function downloadFile($cid, $fileName, $downloadUrl) {
        return $this->sendRequest(self::GET, 'downloadFile', ['cid'=>$cid, 'fileName'=>$fileName, 'downloadUrl'=>$downloadUrl]);
    }
    
    public function createFolder($cid, $moduleNumber, $desiredFolderName, $sourceDirectory) { 
        return $this->sendRequest(self::GET, 'createFolder', ['cid'=>$cid, 
            'moduleNumber'=>$moduleNumber, 
            'desiredFolderName'=>$desiredFolderName, 
            'sourceDirectory'=>$sourceDirectory]);
    }
}
