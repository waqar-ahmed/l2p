<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of SharedDocsController
 *
 * @author odgiiv
 */
class SharedDocsController extends L2pController {
    
    public function viewAllSharedDocumentCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllSharedDocumentCount', ['cid'=>$cid]);
    }
    
    public function viewAllSharedDocuments($cid) {
        return $this->sendRequest(self::GET, 'viewAllSharedDocuments', ['cid'=>$cid]);
    }
}
