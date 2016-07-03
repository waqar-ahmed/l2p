<?php

namespace App\Http\Controllers;

use App\Services\L2pRequestManager;
use Carbon\Carbon;
/**
 * Description of WhatsNewController
 *
 * @author odgiiv
 */
class WhatsNewController extends L2pController {
    
    private $learningMaterialController;
    private $courseController; 
    
    public function __construct(L2pRequestManager $requestManager, 
            LearningMaterialController $lmContr,
            CourseController $crsContr) {        
        parent::__construct($requestManager);
        $this->learningMaterialController = $lmContr;
        $this->courseController = $crsContr;
    }
    
    
    public function whatsAllNewSince($pastMinutes) {
        return $this->sendRequest(self::GET, 'whatsAllNewSince', ['pastMinutes'=>$pastMinutes]);
    }    
    
    public function whatsAllNewSinceForSemester($sem, $pastMinutes) {
        return $this->sendRequest(self::GET, 'whatsAllNewSince', ['pastMinutes'=>$pastMinutes, 'semester'=>$sem]);
    }    
    
    public function whatsNew($cid) {
        return $this->sendRequest(self::GET, 'whatsNew', ['cid'=>$cid]);
    }    
    
    public function whatsNewSince($cid, $pastMinutes) {
        return $this->sendRequest(self::GET, 'whatsAllNewSince', ['cid'=>$cid, 'pastMinutes'=>$pastMinutes]);
    }    
    
    public function whatsNewLearningMaterial($pastMinutes) {
        $result = [];
        $allCoursesCurrentSemester = $this->courseController->viewAllCourseInfoByCurrentSemester();
        if($allCoursesCurrentSemester["Status"]) {
            foreach($allCoursesCurrentSemester["dataSet"] as $course) {                
                $newMaterials = $this->getLearningMaterials($course["uniqueid"], $pastMinutes);
                if(!empty($newMaterials)) {
                    $result += array($course["uniqueid"]=>$newMaterials);
                }                
            }
        }              
        
        return $result;
    }
    
    private function getLearningMaterials($cid, $pastMinutes) {
        $result = [];
        $materials = $this->learningMaterialController->viewAllLearningMaterials($cid);        
        if($materials["Status"]) {
            $now = new Carbon();
            foreach($materials["dataSet"] as $mater) {
                $lastModifiedTime = Carbon::createFromTimestamp($mater["lastModified"]);
                $diffMins = $lastModifiedTime->diffInMinutes($now, true);                
                if($diffMins <= $pastMinutes) {
                    array_push($result, $mater);
                }
            }
        }          
        return $result;
    }
}
