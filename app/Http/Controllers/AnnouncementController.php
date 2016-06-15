<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of AnnouncementController
 *
 * @author odgiiv
 */
class AnnouncementController extends L2pController {       
        
    protected $validations = [
        'body' => 'string',
        'expiretime' => 'numeric',                     
        'title' => 'required|string',      
    ];    

    public function viewAllAnouncementCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnouncements($cid) {
        return $this->sendRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid]);
    }
    
    public function viewAnnouncement($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid, 'itemid'=>$itemId]);
    }        
    
    public function addAnnouncement(Request $request, $cid) {          
        return $this->addToModule($request, 'addAnnouncement', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteAnnouncement($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteAnnouncement', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function updateAnnouncement(Request $request, $cid, $itemId) {        
        return $this->addToModule($request, 'updateAnnouncement', ['cid'=>$cid, 'itemid'=>$itemId], $this->validations);        
    }
    
    public function uploadInAnnouncement(Request $request, $cid, $attachmentDir) {        
    }
}
