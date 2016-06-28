<?php

namespace App\Http\Controllers;

class CourseController extends L2pController
{       
    
    public function _viewCourse($cid){
        return view('single_course', array('cid'=>$cid));
    }
    
    public function viewAllCourseInfoBySemester($sem){        
        return $this->sendRequest(self::GET, 'viewAllCourseInfoBySemester', ['semester'=>$sem]);
    }
    
    public function _viewAllCourseInfo() {
        $allCourses = $this->sendRequest(self::GET, 'viewAllCourseInfo');        
        return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCouseInfo(){                
        return $this->sendRequest(self::GET, 'viewAllCourseInfo');        
        //return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCourseInfoByCurrentSemester() {
        return $this->sendRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');
    }        
    
    public function viewAllAnouncementCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnouncements($cid) {
        return $this->sendRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid]);
    }
    
    public function viewActiveFeatures($cid) {
        return $this->sendRequest(self::GET, 'viewActiveFeatures', ['cid'=>$cid]);
    }    
    
    public function viewAllCounts($cid) {
        return $this->sendRequest(self::GET, 'viewAllCounts', ['cid'=>$cid]);
    }       
        
    public function viewAllEmails($cid) {
        return $this->sendRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinkCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllHyperlinkCount', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinks($cid) {
        return $this->sendRequest(self::GET, 'viewAllHyperlinks', ['cid'=>$cid]);
    }               
    
    public function viewAllLearningObjects($cid) {
        return $this->sendRequest(self::GET, 'viewAllLearningObjects', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteratures($cid) {
        return $this->sendRequest(self::GET, 'viewAllLiterature', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteraturesCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllLiteratureCount', ['cid'=>$cid]);
    }         
    
    public function viewAllMediaLibraries($cid) {
        return $this->sendRequest(self::GET, 'viewAllMediaLibraries', ['cid'=>$cid]);
    }
    
    public function viewAllMediaLibraryCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllMediaLibraryCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocumentCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllSharedDocumentCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocuments($cid) {
        return $this->sendRequest(self::GET, 'viewAllSharedDocuments', ['cid'=>$cid]);
    }
    
    public function viewAllWikiCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllWikiCount', ['cid'=>$cid]);
    }
    
    public function viewAllWikis($cid) {
        return $this->sendRequest(self::GET, 'viewAllWikis', ['cid'=>$cid]);
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
    
    public function viewHyperLink($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewHyperlink', ['cid'=>$cid, 'itemid'=>$itemId]);               
    }        
    
    public function viewLearningObject($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewLearningObject', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewLiterature($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewLiterature', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewMediaLibrary($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewMediaLibrary', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewMyGroupWorkspace($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewMyGroupWorkspace', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewUserRole($cid) {
        return $this->sendRequest(self::GET, 'viewUserRole', ['cid'=>$cid]);                                       
    }
    
    public function viewWiki($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewWiki', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewWikiVersion($cid, $itemId, $versionId) {
        return $this->sendRequest(self::GET, 'viewWikiVersion', ['cid'=>$cid, 'itemid'=>$itemId, 'versionid'=>$versionId]);                                       
    }            
}
