<?php

namespace App\Http\Controllers;

use App\Services\L2pRequestManager;
use Illuminate\Http\Request;
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
    
    protected function addToModule($request, $uri, $uriQuery = [], $validations = []) {                
        if (empty($validations)) {
            if (!is_null($this->validations)) {
                $validations = $this->validations;
            }                   
        }        
        $validator = Validator::make($request->all(), $validations);
        if ($validator->fails()) {
            return $this->jsonResponse(self::STATUS_FALSE, $validator->errors()->all());            
        }   
        return $this->sendRequest(self::POST, $uri, $uriQuery, $this->addParamsReq2Req($request, array_keys($validations)), true);        
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
        
    public function viewAllSemesters() {
        $semesters = array();
        $allCourses = $this->sendRequest(self::GET, 'viewAllCourseInfo');        
        if($allCourses['Status']) {
            foreach($allCourses['dataSet'] as $course) {
                if(!in_array($course['semester'], $semesters)) {
                    array_push($semesters, $course['semester']);
                }
            }
        }       
        $arr = array();
        $sortedSemesters = $this->sortSemesters($semesters);        
        array_walk($sortedSemesters, function ($key, $semester) use (&$arr) {             
            return $arr[] = array($key=>$semester);            
        });
        return $this->jsonResponse(self::STATUS_TRUE, $arr);                
    }        
    
    public function _sortSemesters(Request $request) {        
        return $this->sortSemesters(array_map('trim', explode(',', $request->input('semesters'))));                
    }
    
    public function _viewTesterPage(){ 
        return view('tester');
    }
    
    private function sortSemesters($semesters) { 
        if(is_null($semesters)) {
            return nul;
        }
        $sortedSemesters = array();
        $this->sort($semesters, function ($val1, $val2) {
            if($val1 === $val2) {
                return 0;
            }            
            if((int)substr($val1, 2) > (int)substr($val2, 2)) {
               return 1;
            } else if((int)substr($val1, 2) < (int)substr($val2, 2)) {
                return -1;
            } else {
                if('w' === substr($val1, 0, 1)) {
                    return 1;
                } else if('s' === substr($val1, 0, 1)) {
                    return -1;
                }
            }
        });
        foreach($semesters as $sem) {
            $fullText = $sem;
            switch (substr($sem, 0, 2)) {
                case 'ss': 
                    $fullText = 'Summer semester ';
                    break;
                case 'ws':
                    $fullText = 'Winter semester ';
                    break;               
            }
            if ($fullText != $sem) {
                $fullText .=  (2000 + (int)(substr($sem, 2)));                                
            }
            $sortedSemesters += array($fullText=>$sem);
        }        
        return $sortedSemesters;
    }        

    protected function sort(&$array, $compareFunc, $order='asc') {
        if(1 >= count($array)) {
            return $array;
        }
        foreach($array as $ind1=>$val1) {
            foreach ($array as $ind2=>$val2) {
                switch ($compareFunc($val1, $val2)){
                    case 1:
                        if('asc' === $order) {
                            $this->swap($ind1, $ind2, $array);
                        } 
                        break;
                    case -1:
                        if('des'=== $order) {
                            $this->swap($ind1, $ind2, $array);
                        }
                        break;                        
                    case 0:                         
                        break;
                }
            }
        }
        return $array;
    }        
    
    protected function swap($ind1, $ind2, &$array) {
        if(0 >= count($array) ||  $ind1 < 0 || $ind2 < 0 || $ind1 === $ind2
                || count($array) <= $ind1 || count($array) <= $ind2) {
            return $array; //FIXME: or throw exception
        }
        $temp = $array[$ind1];
        $array[$ind1] = $array[$ind2];
        $array[$ind2] = $temp;
    }
    
}
