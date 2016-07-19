<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inboxTrait
 *
 * @author odgiiv
 */
trait InboxTrait {
    
    public function inbox($pastMinutes, $moduleUrl) {
        $alles = array();
        $openCourses = $this->getCurrentCourses();
        if($openCourses === false) {
            return $this->jsonResponse(self::STATUS_FALSE, 'Can not get courses by current semester');
        }
        foreach($openCourses as $course) {
            $courseEmails = $this->sendRequest(self::GET, $moduleUrl, ['cid'=>$course['uniqueid']]);
            if($courseEmails['Status'] && !empty($courseEmails['dataSet'])) {                
                foreach($courseEmails['dataSet'] as $value) {
                    $value['courseName'] = $course['courseTitle'];
                    array_push($alles, $value);
                }
            } //TODO: if else write log error
        }        
        return $this->jsonResponse(self::STATUS_TRUE, array_reverse(array_sort(
                array_filter($alles, function($var) use ($pastMinutes) {
                    return $this->filterByTime($var, $pastMinutes, 'created');
                }), function($val) {
            return $val['created'];
        })));
    }
    
    public function filterByTime($var, $pastMinutes, $timeVarName) {
        $now = new Carbon();
        $lastModifiedTime = Carbon::createFromTimestamp($var[$timeVarName]);
        $diffMins = $lastModifiedTime->diffInMinutes($now, true); 
        if($diffMins <= $pastMinutes) {
            return true;
        }        
        return false;
    }
    
    public function getCurrentCourses() {        
        $courseInfoArray = $this->sendRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');        
        if ($courseInfoArray['Status']) {
            $courses = array();
            $dataSet = $courseInfoArray['dataSet'];
            foreach($dataSet as $data) {
                if($data['Status']) {
                    array_push($courses, $data);                                                            
                }                                                
            }
            return $courses;
        } else {            
            //TODO: log error
            return false;
        }         
    }
}
