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
            
    public function viewCourseInfo($cid) {
        return $this->sendRequest(self::GET, 'viewCourseInfo', ['cid'=>$cid]);
    }                                        
}
