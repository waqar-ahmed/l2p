<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of DiscussionController
 *
 * @author odgiiv
 */
class DiscussionController extends L2pController {

    protected $validations = [
        'body' => 'required|string',
        'subject' => 'required|string',
    ];

    public function viewAllDiscussionItemCount($cid) {
        return $this->sendRequest(self::GET, 'viewAllDiscussionItemCount', ['cid'=>$cid]);
    }

    public function viewAllDiscussionItems($cid) {
        return $this->sendRequest(self::GET, 'viewAllDiscussionItems', ['cid'=>$cid]);
    }

    public function viewAllDiscussionRootItems($cid) {
        return $this->sendRequest(self::GET, 'viewAllDiscussionRootItems', ['cid'=>$cid]);
    }

    public function addDiscussionThread(Request $request, $cid) {
        return $this->addToModule($request, 'addDiscussionThread', ['cid'=>$cid], $this->validations);
    }

    public function addDiscussionThreadReply(Request $request, $cid, $replyToId) {
        return $this->addToModule($request, 'addDiscussionThreadReply', ['cid'=>$cid, 'replyToId'=>$replyToId], $this->validations);
    }

    public function updateDiscussionThread(Request $request, $cid, $selfId) {
        return $this->addToModule($request, 'updateDiscussionThread', ['cid'=>$cid, 'selfid'=>$selfId], $this->validations);
    }

    public function updateDiscussionThreadReply(Request $request, $cid, $selfId) {
        return $this->addToModule($request, 'updateDiscussionThreadReply', ['cid'=>$cid, 'selfid'=>$selfId], $this->validations);
    }

    public function deleteDiscussionItem($cid, $selfId) {
        return $this->sendRequest(self::GET, 'deleteDiscussionItem', ['cid'=>$cid, 'selfid'=>$selfId]);
    }
}
