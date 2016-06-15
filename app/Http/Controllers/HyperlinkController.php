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
    
    public function addHyperlink(Request $request, $cid) {}
    
    public function deleteHyperlink() {}
    
    public function viewAllHyperlinks() {}
    
    public function viewAllHyperlinksCount  () {}
    
    public function viewHyperlink() {}
        
}
