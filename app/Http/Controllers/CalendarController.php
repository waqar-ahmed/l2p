<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 *
 *
 * @author odgiiv
 */
class CalendarController extends L2pController {
    
    protected $validations = [
        'allDay' => 'boolean',
        'category' => 'string',                     
        'contentType' => 'string',      
        'description' => 'string',      
        'location' => 'string',      
        'endDate' => 'required|numeric',      
        'eventDate' => 'required|numeric',      
        'title' => 'required|string',              
    ];   
    
    public function viewAllCourseEvents() {
        return $this->sendRequest(self::GET, 'viewAllCourseEvents');
    }       
        
    public function viewCourseEvents($cid) {
        return $this->sendRequest(self::GET, 'viewCourseEvents', ['cid'=>$cid]);
    }
    
    public function addCourseEvent(Request $request, $cid) {
        return $this->addToModule($request, 'addCourseEvent', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteCourseEvent($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteCourseEvent', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function updateCourseEvent(Request $request, $cid) {
        return $this->addToModule($request, 'updateCourseEvent', ['cid'=>$cid], $this->validations);
    }
    
}
