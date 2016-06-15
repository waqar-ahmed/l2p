<?php

namespace App\Http\Controllers;

/**
 * Description of WhatsNewController
 *
 * @author odgiiv
 */
class WhatsNewController extends L2pController {
    
    public function whatsAllNewSince($pastMinutes) {
        return $this->sendRequest(self::GET, 'whatsAllNewSince', ['pastMinutes'=>$pastMinutes]);
    }    
    
    public function whatsAllNewSinceForSemester($sem, $pastMinutes) {
        return $this->sendRequest(self::GET, 'whatsAllNewSince', ['pastMinutes'=>$pastMinutes, 'semester'=>$sem]);
    }    
    
    public function whatsNew($cid) {
        return $this->sendRequest(self::GET, 'whatsNew', ['cid'=>$cid]);
    }    
    
    public function whatsNewSince($cid, $pastMinutes) {
        return $this->sendRequest(self::GET, 'whatsAllNewSince', ['cid'=>$cid, 'pastMinutes'=>$pastMinutes]);
    }    
}
