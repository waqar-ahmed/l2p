<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of HyperlinkController
 *
 * @author odgiiv
 */
class HyperlinkController extends L2pController {
    
    protected $validations = [
        'description' => 'string',
        'notes' => 'string',
        'url' => 'required|string',        
    ];
    
    public function addHyperlink(Request $request, $cid) {
        return $this->addToModule($request, 'addHyperlink', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteHyperlink($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteHyperlink', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function updateHyperlink(Request $request, $cid, $itemId) {
        return $this->addToModule($request, 'updateHyperlink', ['cid'=>$cid, 'itemid'=>$itemId], $this->validations);
    }
    
    public function viewAllHyperlinks($cid) {
        return $this->sendRequest(self::GET, 'viewAllHyperlinks', ['cid'=>$cid]);
    }
    
    public function viewAllHyperlinkCount  ($cid) {
        return $this->sendRequest(self::GET, 'viewAllHyperlinkCount', ['cid'=>$cid]);
    }
    
    public function viewHyperlink($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewHyperlink', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
        
}
