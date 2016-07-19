<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of LearningMaterialController
 *
 * @author odgiiv
 */
class LearningMaterialController extends L2pController {
    
    public function viewAllLearningMaterials($cid) {
        return $this->sendRequest(self::GET, 'viewAllLearningMaterials', ['cid'=>$cid]);
    }       
    
    public function viewLearningMaterial($cid, $itemId) {
        return $this->sendRequest(self::GET, 'viewLearningMaterial', ['cid'=>$cid, 'itemid'=>$itemId]);               
    }
    
    public function viewLearningMaterialCount($cid) {
        return $this->sendRequest(self::GET, 'viewLearningMaterialCount', ['cid'=>$cid]);                               
    }
    
    public function deleteLearningMaterial($cid, $itemId) {
        return $this->sendRequest(self::GET, 'deleteLearningMaterial', ['cid'=>$cid, 'itemid'=>$itemId]);                               
    }
    
    public function uploadInLearningMaterial(Request $request, $cid) {
        $valid = [
            'fileName' => 'required|string',
            'stream' => 'required|string',
        ];
        if(!$request->has('sourceDirectory') && is_string($request->input('sourceDirectory')) ) {
            return $this->jsonResponse(self::STATUS_FALSE, 'sourceDirectory field is required and must be string.');            
        }
        return $this->addToModule($request, 'uploadInLearningMaterials', ['cid'=>$cid, 'sourceDirectory'=>$request->input('sourceDirectory')], $valid);        
    }
    
}
