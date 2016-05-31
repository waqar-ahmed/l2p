<?php

namespace App\Services;
/**
 *
 * @author odgiiv
 */
interface L2pTokenManager {
    public function saveDeviceToken($data);
    public function saveAccessToken($data, $oldToken);
    public function checkAccessToken($token);
    public function requestNewAccessToken($deviceToken);
    public function refreshAccessToken($oldToken);
}
