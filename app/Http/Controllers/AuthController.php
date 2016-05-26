<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use \Config;
use App\DeviceToken;
use App\AccessToken;
use App\Services\RequestManager;
use App\Services\TokenManager;
use Illuminate\Support\Facades\Cookie;
use Auth;

class AuthController extends Controller
{

    protected $requestManager; 
    protected $responseJson;
    protected $tokenManager;
    
    const STATUS_FALSE = 'false';
    const STATUS_TRUE = 'true';
    

    public function __construct()
    {
        $this->requestManager = new RequestManager(); 
        $this->tokenManager = new TokenManager();   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function requestUserCode()
    {
        //Create post request parameter with client id and scopes
        $params = [
                'client_id' => Config::get('l2pconfig.client_id'), 
                'scope' => Config::get('l2pconfig.scope')
        ];

        // Execute the post request and get the verification url and user code
        
        $result = $this->requestManager->executePostRequest(Config::get('l2pconfig.user_code_url'), $params);
            
        if($result['code'] != 200)
        {
            return json_encode(array('code'=>code, 'error'=>'Error executing request'));
        }        

        // Since it is json object, so decode it to array
        $this->responseJson = (array)json_decode($result['body']);

        $this->tokenManager->saveDeviceToken($this->responseJson);                

        // Create a complete verification url with user code
        $redirectUrl = $this->responseJson['verification_url'] .'?q=verify&d=' . $this->responseJson['user_code'];

        // Redirect user to verification url
        return Redirect::to($redirectUrl)->withCookie(cookie()->forever('dcode', $this->responseJson['device_code']));   
    }

    public function verifyRequest($deviceCode)
    {               
        $params = [
                'client_id' => Config::get('l2pconfig.client_id'), 
                'code' => $deviceCode,
                'grant_type'=>'device'
        ];

        $result = $this->requestManager->executePostRequest(Config::get('l2pconfig.access_token_url'), $params); 
        
        if($result['code'] != 200)
        {            
            //FIXME:
            return json_encode(array('code'=>$result['code'], 'error'=>'Error executing request'));
        } 

        $accessToken = $this->tokenManager->saveAccessToken($result['body']);                        
        
        $deviceToken = DeviceToken::where('device_code', $deviceCode)->first();
        $deviceToken['access_token_id'] = $accessToken['id'];
        $deviceToken->save();
        
        return $accessToken['access_token'];
    }    

    public function authenticateUser() {            
        $dtoken = Cookie::get('dcode');        
        $accessToken = null;
        if (is_null($dtoken)) {     //no cookie            
            return self::STATUS_FALSE;       //in this case show login link
        }   
                    
        $deviceToken = DeviceToken::where('device_code', $dtoken)->first();                        
        if (is_null($deviceToken)) {        //device token is deleted from db                                                                    
            return self::STATUS_FALSE;
        } else {     
            if(is_null($deviceToken->accessToken)) {               
                $accessToken = $this->tokenManager->requestNewAccessToken($deviceToken);
            } else {
                $accessToken = $this->tokenManager->checkAccessToken($deviceToken->accessToken);                                
            }
        }
        
        if(is_null($accessToken)) {
            return self::STATUS_FALSE;
        }
        
        Auth::loginUsingId($accessToken['id']);     //authenticate user by id
                 
        $response = new Response(self::STATUS_TRUE);        
        return $response;                
    }      
    
    //TODO: Since on logout, cookie is wiped out, clear it also from db
    public function logout() {
        if (Auth::check()) {
            $accesToken = Auth::user()->access_token;
            Auth::logout();        
            AccessToken::where('access_token', $accesToken)->first()->delete();                        
        }                        
        $cookie = Cookie::forget('dcode');
        $response = new Response(self::STATUS_TRUE);
        return $response->withCookie($cookie);
    }
}
