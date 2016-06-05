<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Config;
use App\DeviceToken;
use App\AccessToken;
use Illuminate\Support\Facades\Cookie;
use Auth;

class AuthController extends L2pController {                      
    
    //TODO: on new requestUserCode delete old device tokens from db
    public function login() {        
        $params = ['form_params' => [
            'client_id' => Config::get('l2pconfig.client_id'), 
            'scope' => Config::get('l2pconfig.scope'),
            ]                
        ];
        // Execute the post request and get the verification url and user code etc.        
        $result = $this->requestManager->executeRequest(self::POST, Config::get('l2pconfig.user_code_url'), $params);        
        
        if($result['code'] != 200) //if there is error
        {            
            return $this->jsonResponse(self::STATUS_FALSE, $result['reason_phrase']);
        }        

        // Since it is json object, so decode it to array
        $responseJson = json_decode($result['body'], true);
        if($responseJson['status'] != 'ok') { //if there is error
            return $this->jsonResponse(self::STATUS_FALSE, $responseJson['status']);
        }
                
        if(DeviceToken::create($responseJson)){ //save device token
            // Create a complete verification url with user code
            $redirectUrl = $responseJson['verification_url'] .'?q=verify&d=' . $responseJson['user_code'];

            // Redirect user to verification url
            return Redirect::to($redirectUrl)->withCookie(cookie()->forever('dcode', $responseJson['device_code']));   
        }   
        // Default
        return $this->jsonResponse(self::STATUS_FALSE, 'couldn\'t store device token to db.' );
    }

    public function authenticateUser() {            
        $dtoken = Cookie::get('dcode');                
        if (is_null($dtoken)) {     //no cookie                       
            return $this->jsonResponse(self::STATUS_FALSE, 'You should login first');
        }   
                    
        $deviceToken = DeviceToken::where('device_code', $dtoken)->first();  
        
        if (is_null($deviceToken)) {        //device token is deleted from db                                                                    
            return $this->jsonResponse(self::STATUS_FALSE, 'You should login first');
        }
            
        if(is_null($deviceToken->accessToken)) {               
            $accessToken = $this->requestNewAccessToken($deviceToken);
        } else {
            $accessToken = $this->checkAccessToken($deviceToken->accessToken);                                                              
        }
        
        if($accessToken === false) {
            return $this->defaultResponse;
        }
        
        //TODO: check if user is already authenticated        
        $user = Auth::loginUsingId($accessToken['id']);     //authenticate user by id
        if(is_null($user)) {
            return $this->jsonResponse(self::STATUS_FALSE, 'Error while logging in');
        }                               
        return $this->jsonResponse(self::STATUS_TRUE, 'Logged in');
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
        $params = ['form_params' => [
            'client_id' => Config::get('l2pconfig.client_id'), 
            'code' => $deviceToken['device_code'],
            'grant_type'=>'device'
            ]   
        ];

        $result = $this->requestManager->executeRequest('POST', Config::get('l2pconfig.access_token_url'), $params);         
        if($result['code'] != 200)
        {                
            $this->defaultResponse = $this->jsonResponse(self::STATUS_FALSE, $result['reason_phrase']);
            return false;
        } 
                
        $accessToken = $this->saveAccessToken($result['body']);  
        if($accessToken === false) {
            return false;
        }
        $deviceToken->access_token_id = $accessToken['id'];
        $deviceToken->save();
        return $accessToken;                   
    }                       
    
    // In case if access token expires, then use this url to request new access token using refresh token
    public function refreshAccessToken($oldToken) {
        $params = ['form_params' => [
            'client_id' => Config::get('l2pconfig.client_id'),
            'refresh_token' => $oldToken['refresh_token'],
            'grant_type' => 'refresh_token'
            ]   
        ];

        $result = $this->requestManager->executeRequest('POST', Config::get('l2pconfig.access_token_url'), $params);

        if ($result['code'] != 200) {
            $this->defaultResponse = $this->jsonResponse(self::STATUS_FALSE, $result['reason_phrase']);
            return false;
        }

        return $this->saveAccessToken($result['body'], $oldToken);
    }
    
    public function saveAccessToken($data, $oldToken = null) {
        $resultJson = json_decode($data, true);
        if ($resultJson['status'] == 'ok') {
            if (is_null($oldToken)) {
                return AccessToken::create($resultJson);
            }
            
            $oldToken->access_token = $resultJson['access_token'];
            $oldToken->save();            
            return $oldToken;
        }

        $this->defaultResponse = $this->jsonResponse(self::STATUS_FALSE, $resultJson['status']);
        return false; 
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
    
    //Since on logout, cookie is wiped out, clear it also from db
    public function logout() {
        if (Auth::check()) {
            $accesToken = Auth::user()->access_token;
            Auth::logout();        
            AccessToken::where('access_token', $accesToken)->first()->delete();                        
        }                        
        $cookie = Cookie::forget('dcode');
        return $this->jsonResponse(self::STATUS_TRUE, 'logged out')->withCookie($cookie);
    }
}
