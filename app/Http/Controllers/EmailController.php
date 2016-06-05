<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;


/**
 * Description of EmailController
 *
 * @author odgiiv
 */
class EmailController extends L2pController {
        
    public function inbox() {
        $allEmails = array();
        $openCourseIds = $this->getCurrentCourses();
        if($openCourseIds === false) {
            return $this->jsonResponse(self::STATUS_FALSE, 'Can not get courses by current semester');
        }
        foreach($openCourseIds as $courseId) {
            $courseEmails = $this->sendRestRequest(self::GET, 'viewAllEmails', ['cid'=>$courseId]);
            if($courseEmails['Status']) {
                $allEmails += $courseEmails['dataSet'];
            }            
        }
        
        return $this->jsonResponse(self::STATUS_TRUE, array_reverse(array_sort($allEmails, function($val) {
            return $val['created'];
        })));
    }
    
    private function getCurrentCourses() {        
        $courseInfoArray = $this->sendRestRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');        
        if ($courseInfoArray['Status']) {
            $courses = array();
            $dataSet = $courseInfoArray['dataSet'];
            foreach($dataSet as $data) {
                if($data['Status']) {
                    array_push($courses, $data['uniqueid']);                                                            
                }                                                
            }
            return $courses;
        } else {            
            //TODO: log error
            return false;
        }         
    }
    
    public function addEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'attachmentsToUpload' => 'json',
            'body' => 'string',
            'cc' => 'string',
            'replyto' => 'bool',
            'cid' => 'required',
            'recipients' => 'required',
            'subject' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->jsonResponse(self::STATUS_FALSE, $validator->errors()->all());            
        }
        $params = $this->addParamsReq2Req($request, ['attachmentsToUpload', 'body',
            'cc', 'replyto', 'cid', 'recipients', 'subject',]);
        return $this->sendRestRequest(self::POST, 'addEmail', $params);        
    }
    
    public function viewAllEmails($cid) {        
        return $this->sendRestRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }
    
    public function viewEmail($cid, $itemId) {        
        return $this->sendRestRequest(self::GET, 'viewAllEmails', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    
}
