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
            return $this->jsonResponse(self::STATUS_FALSE, $response['body']);
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

    public function createFolder(Request $request, $cid) {
        $valid = [
            'moduleNumber'=>'required|integer',
            'desiredFolderName'=>'required|string',
            'sourceDirectory'=>'string'
        ];
        $validator = Validator::make($request->all(), $valid);
        if ($validator->fails()) {
            return $this->jsonResponse(self::STATUS_FALSE, $validator->errors()->all());
        }
        $requestParams = [
            'cid'=>$cid,
            'moduleNumber'=>$request->input('moduleNumber'),
            'desiredFolderName'=>$request->input('desiredFolderName'),
        ];
        if($request->has('sourceDirectory')) {
            $requestParams += ['sourceDirectory'=> $request->input('sourceDirectory')];
        }
        return $this->sendRequest(self::GET, 'createFolder', $requestParams);
    }

    public function _viewTesterPage(){
        return view('tester');
    }            
    
    public function viewAllCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllCount', ['cid'=>$cid]);
    }       

    public function viewActiveFeatures($cid) {
        return $this->sendRequest(self::GET, 'viewActiveFeatures', ['cid'=>$cid]);
    }

    public function viewAvailableGroupsInGroupWorkspace($cid) {
        return $this->sendRequest(self::GET, 'viewAvailableGroupsInGroupWorkspace', ['cid'=>$cid]);
    }

    public function viewExamResults($cid) {
        return $this->sendRequest(self::GET, 'viewExamResults', ['cid'=>$cid]);
    }

    public function viewExamResultsStatistics($cid) {
        return $this->sendRequest(self::GET, 'viewExamResultsStatistics', ['cid'=>$cid]);
    }

    public function viewGradeBook($cid) {
        return $this->sendRequest(self::GET, 'viewGradeBook', ['cid'=>$cid]);
    }

    public function viewMyGroupWorkspace($cid) {
        return $this->sendRequest(self::GET, 'viewMyGroupWorkspace', ['cid'=>$cid]);
    }
}
