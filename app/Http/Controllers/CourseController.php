<?php

namespace App\Http\Controllers;

use App\Services\CourseManager;

class CourseController extends Controller
{
    CONST GET = 'GET';    
    private $courseManager;

    function __construct()
    {
        $this->courseManager = new CourseManager();
    }   
    
    public function viewCourse($cid){
        return view('single_course', array('cid'=>$cid));
    }
    
    public function viewAllCourseInfoBySemester($sem){
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfoBySemester', ['semester'=>$sem]);
    }
    
    public function viewAllCouseInfo(){        
        $allCourses = $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfo');
        return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCourseInfoByCurrentSemester() {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');
    }
    
    public function viewAllCourseEvents($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseEvents', ['cid'=>$cid]);
    }       
    
    public function viewAllAnouncementCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnouncements($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid]);
    }
    
    public function viewActiveFeatures($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewActiveFeatures', ['cid'=>$cid]);
    }
    
    public function viewAllAssignments($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAssignments', ['cid'=>$cid]);
    }
    
    public function viewAllCounts($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCounts', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionItemCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllDiscussionItemCount', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionItems($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllDiscussionItems', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionRootItems($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllDiscussionRootItems', ['cid'=>$cid]);
    }       
    
    public function viewAllEmails($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinkCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllHyperlinkCount', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinks($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllHyperlinks', ['cid'=>$cid]);
    }       
    
    public function viewAllLearningMaterials($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLearningMaterials', ['cid'=>$cid]);
    }       
    
    public function viewAllLearningObjects($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLearningObjects', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteratures($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLiterature', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteraturesCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLiteratureCount', ['cid'=>$cid]);
    }         
    
    public function viewAllMediaLibraries($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllMediaLibraries', ['cid'=>$cid]);
    }
    
    public function viewAllMediaLibraryCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllMediaLibraryCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocumentCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllSharedDocumentCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocuments($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllSharedDocuments', ['cid'=>$cid]);
    }
    
    public function viewAllWikiCount($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllWikiCount', ['cid'=>$cid]);
    }
    
    public function viewAllWikis($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllWikis', ['cid'=>$cid]);
    }
    
    public function viewAvailableGroupsInGroupWorkspace($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAvailableGroupsInGroupWorkspace', ['cid'=>$cid]);
    }
    
    public function viewCourseEvents($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewCourseEvents', ['cid'=>$cid]);
    }
    
    public function viewCourseInfo($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewCourseInfo', ['cid'=>$cid]);
    }
    
    public function viewExamResults($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewExamResults', ['cid'=>$cid]);
    }

    public function viewExamResultsStatistics($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewExamResultsStatistics', ['cid'=>$cid]);
    }
    
    public function viewGradeBook($cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewGradeBook', ['cid'=>$cid]);
    }
}
