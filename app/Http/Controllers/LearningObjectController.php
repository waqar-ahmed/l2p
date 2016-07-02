<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of LearningObjectController
 *
 * @author odgiiv
 */
class LearningObjectController extends L2pController {
    
    public function viewAllLearningObjects($cid) {
        return $this->sendRequest(self::GET, 'viewAllLearningObjects', ['cid'=>$cid]);
    }                                          
    
}
