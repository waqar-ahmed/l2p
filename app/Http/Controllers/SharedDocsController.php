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
    
    public function deleteSharedDocument($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteSharedDocument', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function uploadInSharedDocument(Request $request, $cid) {
        $valid = [            
            'fileName' => 'required|string',
            'stream' => 'required|string',
        ];
        if(!$request->has('sourceDirectory') && is_string($request->input('sourceDirectory')) ) {
            return $this->jsonResponse(self::STATUS_FALSE, 'sourceDirectory field is required and must be string.');            
        }
        return $this->addToModule($request, 'uploadInSharedDocuments', ['cid'=>$cid, 'sourceDirectory'=>$request->input('sourceDirectory')], $valid);        
    }
}
