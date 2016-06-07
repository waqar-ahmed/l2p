<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

/**
 * Description of AnnouncementController
 *
 * @author odgiiv
 */
class AnnouncementController extends L2pController {       
    
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
        $validations = [
            'body' => 'string',
            'expiretime' => 'numeric',                     
            'title' => 'required|string',                        
        ];
        $validator = Validator::make($request->all(), $validations);
        if ($validator->fails()) {
            return $this->jsonResponse(self::STATUS_FALSE, $validator->errors()->all());            
        }        
        $params = $this->addParamsReq2Req($request, ['body', 'expiretime', 'title',]);        
        return $this->sendJsonPostRequest('addAnnouncement', ['cid'=>$cid], $params);        
    }
    
    public function deleteAnnouncement($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteAnnouncement', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function updateAnnouncement(Request $request, $cid, $itemId) {
        $validations = [
            'body' => 'string',
            'expiretime' => 'numeric',                     
            'title' => 'required|string',                        
        ];
        $validator = Validator::make($request->all(), $validations);
        if ($validator->fails()) {
            return $this->jsonResponse(self::STATUS_FALSE, $validator->errors()->all());            
        }        
        $params = $this->addParamsReq2Req($request, ['body', 'expiretime', 'title',]);        
        return $this->sendJsonPostRequest('updateAnnouncement', ['cid'=>$cid, 'itemid'=>$itemId], $params);        
    }
    
    public function uploadInAnnouncement(Request $request, $cid, $attachmentDir) {        
    }
}
