<?php

namespace App\Http\Controllers;

use App\Services\CourseManager;
use Auth;

class CourseController extends Controller
{
    CONST GET = 'GET';    
    private $courseManager;

    function __construct()
    {
        $this->courseManager = new CourseManager();
    }   
    
    private function sendRestRequest($method, $uri, $query = []) {        
        $query += ['accessToken' => Auth::user()->access_token];            
        return $this->courseManager->sendRestRequest($method, $uri, $query);                
    }
    
    public function viewCourse($cid){
        return view('single_course', array('cid'=>$cid));
    }
    
    public function viewAllCourseInfoBySemester($sem){
        return $this->sendRestRequest(self::GET, 'viewAllCourseInfoBySemester', ['semester'=>$sem]);
    }
    
    public function viewAllCouseInfo(){                
        $allCourses = $this->sendRestRequest(self::GET, 'viewAllCourseInfo');
        return $allCourses;
        //return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCourseInfoByCurrentSemester() {
        return $this->sendRestRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');
    }
    
    public function viewAllCourseEvents($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllCourseEvents', ['cid'=>$cid]);
    }       
    
    public function viewAllAnouncementCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnouncements($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid]);
    }
    
    public function viewActiveFeatures($cid) {
        return $this->sendRestRequest(self::GET, 'viewActiveFeatures', ['cid'=>$cid]);
    }
    
    public function viewAllAssignments($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllAssignments', ['cid'=>$cid]);
    }
    
    public function viewAllCounts($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllCounts', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionItemCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllDiscussionItemCount', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionItems($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllDiscussionItems', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionRootItems($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllDiscussionRootItems', ['cid'=>$cid]);
    }       
    
    public function viewAllEmails($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinkCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllHyperlinkCount', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinks($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllHyperlinks', ['cid'=>$cid]);
    }       
    
    public function viewAllLearningMaterials($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllLearningMaterials', ['cid'=>$cid]);
    }       
    
    public function viewAllLearningObjects($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllLearningObjects', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteratures($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllLiterature', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteraturesCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllLiteratureCount', ['cid'=>$cid]);
    }         
    
    public function viewAllMediaLibraries($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllMediaLibraries', ['cid'=>$cid]);
    }
    
    public function viewAllMediaLibraryCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllMediaLibraryCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocumentCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllSharedDocumentCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocuments($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllSharedDocuments', ['cid'=>$cid]);
    }
    
    public function viewAllWikiCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllWikiCount', ['cid'=>$cid]);
    }
    
    public function viewAllWikis($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllWikis', ['cid'=>$cid]);
    }
    
    public function viewAvailableGroupsInGroupWorkspace($cid) {
        return $this->sendRestRequest(self::GET, 'viewAvailableGroupsInGroupWorkspace', ['cid'=>$cid]);
    }
    
    public function viewCourseEvents($cid) {
        return $this->sendRestRequest(self::GET, 'viewCourseEvents', ['cid'=>$cid]);
    }
    
    public function viewCourseInfo($cid) {
        return $this->sendRestRequest(self::GET, 'viewCourseInfo', ['cid'=>$cid]);
    }
    
    public function viewExamResults($cid) {
        return $this->sendRestRequest(self::GET, 'viewExamResults', ['cid'=>$cid]);
    }

    public function viewExamResultsStatistics($cid) {
        return $this->sendRestRequest(self::GET, 'viewExamResultsStatistics', ['cid'=>$cid]);
    }
    
    public function viewGradeBook($cid) {
        return $this->sendRestRequest(self::GET, 'viewGradeBook', ['cid'=>$cid]);
    }
}
