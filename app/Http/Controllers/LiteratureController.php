<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of LiteratureController
 *
 * @author odgiiv
 */
class LiteratureController extends L2pController {
    
    protected $validations = [
        'authors' => 'required|string',
        'contentType' => 'required|string',
        'title' => 'required|string',        
        'year' => 'required|string',        
        'publisher' => 'string',    
    ];
    
    public function viewLiterature($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewLiterature', ['cid'=>$cid, 'itemid'=>$itemId]);                                       
    }
    
    public function viewAllLiteratures($cid) {
        return $this->sendRequest(self::GET, 'viewAllLiterature', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteraturesCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllLiteratureCount', ['cid'=>$cid]);
    } 
    
    public function addLiterature(Request $request, $cid) {
        return $this->addToModule($request, 'addLiterature', ['cid'=>$cid], $this->validations);
    }
    
    public function deleteLiterature($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteLiterature', ['cid'=>$cid, 'itemid'=>$itemId]);
    }
    
    public function updateLiterature(Request $request, $cid, $itemId) {
        return $this->addToModule($request, 'updateLiterature', ['cid'=>$cid, 'itemid'=>$itemId], $this->validations);
    }    
}
