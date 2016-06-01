<?php

namespace App\Http\Controllers;

/**
 * Description of AnnouncementController
 *
 * @author odgiiv
 */
class AnnouncementController extends L2pController {       
    
    public function viewAllAnouncementCount($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnouncements($cid) {
        return $this->sendRestRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid]);
    }
}
