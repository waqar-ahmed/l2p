<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of WikiController
 *
 * @author odgiiv
 */
class WikiController extends L2pController {
    
    public function viewWiki($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewWiki', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewWikiVersion($cid, $itemId, $versionId) {
        return $this->sendRequest(self::GET, 'viewWikiVersion', ['cid'=>$cid, 'itemid'=>$itemId, 'versionid'=>$versionId]);                                       
    }
    
    public function viewAllWikiCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllWikiCount', ['cid'=>$cid]);
    }
    
    public function viewAllWikis($cid) {
        return $this->sendRequest(self::GET, 'viewAllWikis', ['cid'=>$cid]);
    }
}
