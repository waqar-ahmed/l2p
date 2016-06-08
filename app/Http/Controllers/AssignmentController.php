<?php

namespace App\Http\Controllers;

/**
 * Description of AssignmentController
 *
 * @author odgiiv
 */
class AssignmentController extends L2pController {
    
    public function viewAllAssignments($cid) {
        return $this->sendRequest(self::GET, 'viewAllAssignments', ['cid'=>$cid]);
    }
    
    
    public function viewAssignment($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewAssignment', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
}
