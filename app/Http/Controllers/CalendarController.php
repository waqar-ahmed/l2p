<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 *
 *
 * @author odgiiv
 */
class CalendarController extends L2pController {
    
    public function viewAllCourseEvents() {
        return $this->sendRequest(self::GET, 'viewAllCourseEvents');
    }       
        
    public function viewCourseEvents($cid) {
        return $this->sendRequest(self::GET, 'viewCourseEvents', ['cid'=>$cid]);
    }

}
