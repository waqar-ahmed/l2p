<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

use \Config;

use App\devicetoken;

use App\Services\RequestManager;

use GuzzleHttp\Client;
use Guzzle\Http\EntityBody;
// use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;

class AuthController extends Controller
{

    protected $requestManager; 
    protected $responseJson;

    public function __construct()
    {
        $this->requestManager = new RequestManager();   
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
        $this->responseJson = $this->requestManager->executePostRequest(Config::get('l2pconfig.user_code_url'), $params);
        
        // Since it is json object, so decode it to array
        $this->responseJson = (array)json_decode($this->responseJson);

        //Save device code into database so we can use that to verify whether user authorized app or not
        $token = new devicetoken;
        $token->user_id = 1;
        $token->device_code = $this->responseJson['device_code'];

        // If user already exist then update database else insert record
        if($token->exists())
        {
            devicetoken::where('user_id', 1)->update(['device_code' => $this->responseJson['device_code']]);
        }
        else
        {
            $token->save();
        }

        // Create a complete verification url with user code
        $redirectUrl = $this->responseJson['verification_url'] .'?q=verify&d=' . $this->responseJson['user_code'];

        // Redirect user to verification url
        return Redirect::to($redirectUrl);   
    }

    public function requestAccessToken()
    {
        // Get device code and check whether user verify the app or not
        $code = devicetoken::where('user_id', 1)->first();

        $params = [
                'client_id' => Config::get('l2pconfig.client_id'), 
                'code' => $code['device_code'],
                'grant_type'=>'device'
        ];

        // Execute the post request and get the verification url and user code
        return $this->requestManager->executePostRequest(Config::get('l2pconfig.access_token_url'), $params);
        
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
