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
        'expireTime' => 'numeric',
        'title' => 'required|string',
    ];

    public function viewAllAnnouncementCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnnouncements($cid) {
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
<<<<<<< HEAD

    public function uploadInAnnouncement(Request $request, $cid, $attachmentDir) {
=======
    
    public function uploadInAnnouncement(Request $request, $cid) {  
        $vali = [            
            'fileName' => 'required|string',
            'stream' => 'required|string',        
        ]; 
        if(!$request->has('attachmentDirectory') && is_string($request->input('attachmentDirectory')) ) {
            return $this->jsonResponse(self::STATUS_FALSE, 'attachmentDirectory field is required.');            
        } 
        return $this->addToModule($request, 'uploadInAnnouncement', ['cid'=>$cid, 'attachmentDirectory'=>$request->input('attachmentDirectory')], $vali);        
>>>>>>> 52fd3e9494be4bbc5c55dff739ce9746fcc75bf9
    }
}
