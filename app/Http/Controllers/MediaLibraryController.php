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
    
    public function uploadInMediaLibrary() {}        
    
}
