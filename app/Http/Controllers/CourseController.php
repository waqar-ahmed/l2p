<?php

namespace App\Http\Controllers;

class CourseController extends L2pController
{       
    
    public function _viewCourse($cid){
        return view('single_course', array('cid'=>$cid));
    }
    
    public function _viewAllCourseInfo() {
        $allCourses = $this->sendRequest(self::GET, 'viewAllCourseInfo');        
        return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCourseInfoBySemester($sem){        
        return $this->sendRequest(self::GET, 'viewAllCourseInfoBySemester', ['semester'=>$sem]);
    }        
    
    public function viewAllCouseInfo(){                
        return $this->sendRequest(self::GET, 'viewAllCourseInfo');        
        //return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCourseInfoByCurrentSemester() {
        return $this->sendRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');
    }               
    
    public function viewActiveFeatures($cid) {
        return $this->sendRequest(self::GET, 'viewActiveFeatures', ['cid'=>$cid]);
    }    
    
    public function viewAllCounts($cid) {
        return $this->sendRequest(self::GET, 'viewAllCounts', ['cid'=>$cid]);
    }       
                            
    public function viewAvailableGroupsInGroupWorkspace($cid) {
        return $this->sendRequest(self::GET, 'viewAvailableGroupsInGroupWorkspace', ['cid'=>$cid]);
    }
            
    public function viewCourseInfo($cid) {
        return $this->sendRequest(self::GET, 'viewCourseInfo', ['cid'=>$cid]);
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
    
    public function viewLearningObject($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewLearningObject', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }        
    
    public function viewMyGroupWorkspace($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewMyGroupWorkspace', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewUserRole($cid) {
        return $this->sendRequest(self::GET, 'viewUserRole', ['cid'=>$cid]);                                       
    }                    
}
