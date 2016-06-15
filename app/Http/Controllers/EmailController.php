<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of EmailController
 *
 * @author odgiiv
 */
class EmailController extends L2pController {
    
    protected $validations = [
        'attachmentsToUpload' => 'json',
        'body' => 'string',
        'cc' => 'string',
        'replyto' => 'bool',
        'recipients' => 'required|string',
        'subject' => 'required|string',
    ];
        
    public function inbox() {
        $allEmails = array();
        $openCourseIds = $this->getCurrentCourses();
        if($openCourseIds === false) {
            return $this->jsonResponse(self::STATUS_FALSE, 'Can not get courses by current semester');
        }
        foreach($openCourseIds as $courseId) {
            $courseEmails = $this->sendRequest(self::GET, 'viewAllEmails', ['cid'=>$courseId]);
            if($courseEmails['Status']) {
                $allEmails += $courseEmails['dataSet'];
            }            
        }
        
        return $this->jsonResponse(self::STATUS_TRUE, array_reverse(array_sort($allEmails, function($val) {
            return $val['created'];
        })));
    }
    
    private function getCurrentCourses() {        
        $courseInfoArray = $this->sendRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');        
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
    
    public function addEmail(Request $request, $cid) {                 
        return $this->addToModule($request->all(), 'addEmail', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteEmail($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteEmail', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function viewAllEmails($cid) {        
        return $this->sendRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }
    
    public function viewEmail($cid, $itemId) {        
        return $this->sendRequest(self::GET, 'viewAllEmails', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function uploadInAnnouncement(Request $request, $cid) {        
    }    
}
