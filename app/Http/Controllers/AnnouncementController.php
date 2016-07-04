<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of AnnouncementController
 *
 * @author odgiiv
 */
class AnnouncementController extends L2pController {
    
    use InboxTrait;        

    protected $validations = [
        'body' => 'string',
        'expireTime' => 'numeric',
        'title' => 'required|string',
    ];
    
    public function inboxAnnouncements($pastMinutes) {
        return $this->inbox($pastMinutes, 'viewAllAnnouncements');
    }

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
    
    public function uploadInAnnouncement(Request $request, $cid) {  
        $valid = [            
            'fileName' => 'required|string',
            'stream' => 'required|string',
        ];
        if(!$request->has('attachmentDirectory') && is_string($request->input('attachmentDirectory')) ) {
            return $this->jsonResponse(self::STATUS_FALSE, 'attachmentDirectory field is required and must be string.');            
        }
        return $this->addToModule($request, 'uploadInAnnouncement', ['cid'=>$cid, 'attachmentDirectory'=>$request->input('attachmentDirectory')], $valid);        
    }       
}
