<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of AssignmentController
 *
 * @author odgiiv
 */
class AssignmentController extends L2pController {
    
    protected $validations = [
        'dueDate' => 'numeric',
        'groupSubmissionAllowed' => 'Boolean',
        'totalMarks' => 'numeric',                     
        'description' => 'required|string', 
        'title' => 'required|string',        
    ];  
    
    public function viewAllAssignments($cid) {
        return $this->sendRequest(self::GET, 'viewAllAssignments', ['cid'=>$cid]);
    }    
    
    public function viewAssignment($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewAssignment', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function addAssignment(Request $request, $cid) {        
        return $this->addToModule($request, 'addAnnouncement', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteAssignment($cid, $itemId) {        
        return $this->sendRequest(self::GET, 'deleteAssignment', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function provideAssignmentSolution(Request $request, $cid, $assignmentId, $gwsNameAlias) {
        $validations = [
            'comment' => 'required|string', 
            'assignmentid' => 'required|integer',
            'gws_name_alias' => 'required|string'
        ];
        return $this->addToModule($request, 'provideAssignmentSolution', ['cid'=>$cid, 'assignmentid'=>$assignmentId, 'gws_name_alias'=>$gwsNameAlias], $validations);        
    }
    
    public function deleteAssignmentSolution($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteAssignmentSolution', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function uploadInAssignments(Request $request, $cid, $solutionDir) {        
    }
}
