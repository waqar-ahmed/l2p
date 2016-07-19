<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of EmailController
 *
 * @author odgiiv
 */
class EmailController extends L2pController {
    
    use InboxTrait;
    
    protected $validations = [
        'attachmentsToUpload' => 'json',
        'body' => 'string',        
        'replyto' => 'bool',
        'cc' => 'required|string',
        'recipients' => 'required|string',
        'subject' => 'required|string',
    ];     
    
    public function inboxEmails($pastMinutes) {
        return $this->inbox($pastMinutes, 'viewAllEmails');
    }
    
    public function addEmail(Request $request, $cid) {                 
        return $this->addToModule($request, 'addEmail', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteEmail($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteEmail', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function viewAllEmails($cid) { 
        return $this->sendRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }
    
    public function viewEmail($cid, $itemId) {        
        return $this->sendRequest(self::GET, 'viewEmail', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function uploadInEmail(Request $request, $cid) {        
        $valid = [
            'fileName' => 'required|string',
            'stream' => 'required|string',
        ];        
        return $this->addToModule($request, 'uploadInEmail', ['cid'=>$cid], $valid);        
    }    
}
