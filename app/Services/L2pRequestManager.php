<?php

namespace App\Services;
/**
 *
 * @author odgiiv
 */
interface L2pRequestManager {        
    public function executeRequest($method, $subUrl, $params, $url = null);
}
