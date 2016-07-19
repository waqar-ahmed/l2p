<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of WikiController
 *
 * @author odgiiv
 */
class WikiController extends L2pController {
    
    protected $validations = [
        'body' => 'string',        
        'title' => 'required|string',
    ];
    
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
    
    public function addWiki(Request $request, $cid) {
        return $this->addToModule($request, 'addWiki', ['cid'=>$cid], $this->validations);
    }
    
    public function updateWiki(Request $request, $cid, $itemId) {
        return $this->addToModule($request, 'updateWiki', ['cid'=>$cid, 'itemid'=>$itemId], $this->validations);
    }
    
    public function deleteWiki($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteWiki', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
}
