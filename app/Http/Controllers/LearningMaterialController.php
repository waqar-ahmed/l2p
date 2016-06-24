<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of LearningMaterialController
 *
 * @author odgiiv
 */
class LearningMaterialController extends L2pController {
    
    public function viewAllLearningMaterials($cid) {
        return $this->sendRequest(self::GET, 'viewAllLearningMaterials', ['cid'=>$cid]);
    }       
    
    public function viewLearningMaterial($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewLearningMaterial', ['cid'=>$cid, 'itemid'=>$itemId]);               
    }
    
    public function viewLearningMaterialCount($cid) {
        return $this->sendRequest(self::GET, 'viewLearningMaterialCount', ['cid'=>$cid]);                               
    }
    
    public function deleteLearningMaterial($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteLearningMaterial', ['cid'=>$cid, 'itemid'=>$itemId]);                               
    }
    
    public function uploadInLearningMaterials($cid, $sourceDir) {
        
    }
    
}
