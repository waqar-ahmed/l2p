<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Config;
use App\DeviceToken;
use App\Services\RequestManager;
use App\Services\TokenManager;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    protected $requestManager; 
    protected $responseJson;
    protected $tokenManager;

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

        $this->responseJson = $result['body'];

        // Since it is json object, so decode it to array
        $this->responseJson = (array)json_decode($this->responseJson);

        $this->tokenManager->saveDeviceToken($this->responseJson);                

        // Create a complete verification url with user code
        $redirectUrl = $this->responseJson['verification_url'] .'?q=verify&d=' . $this->responseJson['user_code'];

        // Redirect user to verification url
        return Redirect::to($redirectUrl)->withCookie(cookie()->forever('dtoken', $this->responseJson['device_code']));   
    }

    public function requestAccessToken()
    {
       echo 'not implemented';
    }

    public function verifyRequest()
    {
        // Get device code and check whether user verify the app or not
        $code = DeviceToken::where('user_id', 1)->first();

        $params = [
                'client_id' => Config::get('l2pconfig.client_id'), 
                'code' => $code['device_code'],
                'grant_type'=>'device'
        ];

        $result = $this->requestManager->executePostRequest(Config::get('l2pconfig.access_token_url'), $params); 
        
        if($result['code'] != 200)
        {            
            return json_encode(array('code'=>$result['code'], 'error'=>'Error executing request'));
        } 

        $this->tokenManager->saveAccessAndRefreshToken($result['body']);
        
        
        // Execute the post request and get the verification url and user code        
        $resultJson = json_decode($result['body'], true);
        $access_token = $resultJson['access_token'];
        $response = new Response($result['body']);
        $response->withCookie(cookie()->forever('atoken', $access_token));        
        return $response;
    }

    public function authenticateUser() {
        $dtoken = Cookie::get('dtoken');
        if (is_null($dtoken)) {
            return "false";
        } else {
            $user = DeviceToken::where('device_code', $dtoken)->user();
            if (is_null($user)) {
                echo "no user";
            }
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
