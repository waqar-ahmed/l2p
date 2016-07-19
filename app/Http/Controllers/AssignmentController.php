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
        return $this->addToModule($request, 'addAssignment', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteAssignment($cid, $itemId) {        
        return $this->sendRequest(self::GET, 'deleteAssignment', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function provideAssignmentSolution(Request $request, $cid, $assignmentId, $gwsNameAlias) {
        $valid = [
            'comment' => 'required|string',             
        ];
        return $this->addToModule($request, 'provideAssignmentSolution', ['cid'=>$cid, 'assignmentid'=>$assignmentId, 'gws_name_alias'=>$gwsNameAlias], $valid);        
    }
    
    public function deleteAssignmentSolution($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteAssignmentSolution', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function uploadInAssignment(Request $request, $cid) {        
        $valid = [
            'fileName' => 'required|string',
            'stream' => 'required|string',
        ];
        if(!$request->has('solutionDirectory') && is_string($request->input('solutionDirectory')) ) {
            return $this->jsonResponse(self::STATUS_FALSE, 'solutionDirectory field is required and must be string.');            
        }
        return $this->addToModule($request, 'uploadInAssignment', ['cid'=>$cid, 'solutionDirectory'=>$request->input('solutionDirectory')], $valid);        
    }
}
