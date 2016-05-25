<?php

namespace App\Services;

use App\DeviceToken;
use App\AccessToken;
use App\Services\RequestManager;
use \Config;

class TokenManager {

    protected $requestManager;    

    function __construct() {
        $this->requestManager = new RequestManager();
    }

    public function saveDeviceToken($result) {
        //Save device code into database so we can use that to verify whether user authorized app or not
        $token = new DeviceToken;
        
        $token->device_code = $result['device_code'];
        $token->user_code = $result['user_code'];
        $token->verification_url = $result['verification_url'];
        $token->expires_in = $result['expires_in'];
        $token->interval = $result['interval'];

        // If user already exist then update database else insert record
//        if ($token->exists()) {
//            devicetoken::where('user_id', 1)->update(['device_code' => $result['device_code']]);
//        } else {
        $token->save();
//        }
    }   

    public function saveAccessToken($result, $oldToken = null) {
        $result = json_decode($result, true);
        if ($result['status'] == 'ok') {
            if (is_null($oldToken)) {
                $token = new AccessToken;
                $token->access_token = $result['access_token'];
                $token->refresh_token = $result['refresh_token'];
                $token->token_type = $result['token_type'];
                $token->expires_in = $result['expires_in'];

                $token->save();
                return $token;
            }
            
            $oldToken->access_token = $result['access_token'];
            $oldToken->save();
            return $oldToken;            
        }        
        //TODO: handle this null, write log, authorization pending error        
        return null; 
    }
    
    //Check if access token is expired or not. if expired return new access token
    public function checkAccessToken($token) {
        if (!$this->isTokenExpires($token['updated_at'], $token['expires_in'])) {
            return $token;
        } else {
            return $this->refreshAccessToken($token);
        }
    }
    
    //Request new access token 
    public function requestNewAccessToken($deviceToken) {        
        $params = [
                'client_id' => Config::get('l2pconfig.client_id'), 
                'code' => $deviceToken['device_code'],
                'grant_type'=>'device'
        ];

        $result = $this->requestManager->executePostRequest(Config::get('l2pconfig.access_token_url'), $params); 
        
        if($result['code'] != 200)
        {                        
            return null;
            //TODO: log this error;
        } 

        $accessToken = $this->saveAccessToken($result['body']);                        
        
        $deviceToken->access_token_id = $accessToken['id'];
        $deviceToken->save();
        return $accessToken;
    }

    // In case if access token expires, then use this url to request new access token using refresh token
    public function refreshAccessToken($oldToken) {
        $params = [
            'client_id' => Config::get('l2pconfig.client_id'),
            'refresh_token' => $oldToken['refresh_token'],
            'grant_type' => 'refresh_token'
        ];

        $result = $this->requestManager->executePostRequest(Config::get('l2pconfig.access_token_url'), $params);

        if ($result['code'] != 200) {
                        
            return null;
            //TODO: log this error;
        }

        return $this->saveAccessToken($result['body'], $oldToken);
    }

    // Check whether the access token is expired or not
    private function isTokenExpires($updatedAt, $limit) {
        //$currentTime = date("Y-m-d h:i:s");
        $currentTime = \Carbon\Carbon::now();
        $differenceInSeconds = strtotime($currentTime) - strtotime($updatedAt);
        if ($differenceInSeconds > $limit) {
            return true;
        } else {
            return false;
        }
    }

}
