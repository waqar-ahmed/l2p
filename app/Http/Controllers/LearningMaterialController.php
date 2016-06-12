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
    
}
