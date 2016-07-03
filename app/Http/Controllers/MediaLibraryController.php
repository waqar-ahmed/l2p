<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of MediaLibraryController
 *
 * @author odgiiv
 */
class MediaLibraryController extends L2pController {
    
    protected $validations = [
        'dueDate' => 'numeric',
        'groupSubmissionAllowed' => 'Boolean',
        'totalMarks' => 'numeric',                     
        'description' => 'required|string', 
        'title' => 'required|string',        
    ]; 
    
    public function deleteMediaLibrary($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteMediaLibrary', ['cid'=>$cid, 'itemid'=>$itemId]);
    }        
    
    public function viewAllMediaLibrariesCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllMediaLibraryCount', ['cid'=>$cid]);
    }
    
    public function viewAllMediaLibraries($cid) {
        return $this->sendRequest(self::GET, 'viewAllMediaLibraries', ['cid'=>$cid]);
    }
    
    public function viewMediaLibrary($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewMediaLibrary', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function uploadInMediaLibrary(Request $request, $cid) {
        $valid = [
            'fileName' => 'required|string',
            'stream' => 'required|string',
        ];
        if(!$request->has('sourceDirectory') && is_string($request->input('sourceDirectory')) ) {
            return $this->jsonResponse(self::STATUS_FALSE, 'sourceDirectory field is required and must be string.');            
        }
        return $this->addToModule($request, 'uploadInMediaLibrary', ['cid'=>$cid, 'sourceDirectory'=>$request->input('sourceDirectory')], $valid);        
    }        
    
}
