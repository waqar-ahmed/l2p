<?php

namespace App\Services;

use App\devicetoken;
use App\accesstoken;
use App\refreshtoken;

use App\Services\RequestManager;

use \Config;

class TokenManager
{

	protected $requestManager;

	function __construct()
	{
		$this->requestManager = new RequestManager();
	}
 
	public function saveDeviceToken($result)
	{
		//Save device code into database so we can use that to verify whether user authorized app or not
        $token = new devicetoken;
        $token->user_id = 1;
        $token->device_code = $result['device_code'];
        $token->user_code = $result['user_code'];
        $token->verification_url = $result['verification_url'];
        $token->expires_in = $result['expires_in'];
        $token->interval = $result['interval'];

        // If user already exist then update database else insert record
        if($token->exists())
        {
            devicetoken::where('user_id', 1)->update(['device_code' => $result['device_code']]);
        }
        else
        {
            $token->save();
        }
	}

	public function saveAccessAndRefreshToken($result)
	{
		echo "saving";
		$this->saveAccessToken($result);
		$this->saveRefreshToken($result);
	}

	private function saveAccessToken($result)
	{
		$result = (array)json_decode($result);

		if($result['access_token'] != null)
		{
			$code = accesstoken::where('user_id', 1)->first();
			if($code != null)
			{
				accesstoken::where('user_id', 1)->update(['access_token' => $result['access_token']]);
				echo "update";
			}
			else
			{
				$token = new accesstoken;
		        $token->user_id = 1;
		        $token->access_token = $result['access_token'];
		        $token->token_type = $result['token_type'];
		        $token->expires_in = $result['expires_in'];

		        $token->save();
		        echo 'saved';
			}
		}
	}

	private function saveRefreshToken($result)
	{

		$result = (array)json_decode($result);

		if($result['refresh_token'] != null)
		{
			$code = refreshtoken::where('user_id', 1)->first();
			if($code != null)
			{
				refreshtoken::where('user_id', 1)->update(['refresh_token' => $result['refresh_token']]);
			}
			else
			{
				$token = new refreshtoken;
		        $token->user_id = 1;
		        $token->refresh_token = $result['refresh_token'];

		        $token->save();
			}
		}
	}

	//Get access token saved in the databse
	public function getAccessToken()
	{
		$token = accesstoken::where('user_id', 1)->first();

		if(!$this->isTokenExpires($token['updated_at'], $token['expires_in']))
		{
			return $token['access_token'];
		}
		else
		{
			return $this->requestNewAccessToken();
		}
	}

	// In case if access token expires, then use this url to request new access token using refresh token
	private function requestNewAccessToken()
	{
		$token = refreshtoken::where('user_id', 1)->first();

		$params = [
                'client_id' => Config::get('l2pconfig.client_id'), 
                'refresh_token' => $token['refresh_token'],
                'grant_type'=>'refresh_token'
        ];

        $result = $this->requestManager->executePostRequest(Config::get('l2pconfig.access_token_url'), $params); 

        if($result['code'] != 200)
        {
            return json_encode(array('code'=>$result['code'], 'error'=>'Error executing request'));
        }

        $this->saveAccessToken($result['body']);

        $result = (array)json_decode($result['body']);
        return $result['access_token'];

	}

	// Check whether the access token is expired or not
	private function isTokenExpires($updatedAt, $limit)
	{
		//$currentTime = date("Y-m-d h:i:s");
		$currentTime = \Carbon\Carbon::now();
		$differenceInSeconds = strtotime($currentTime) - strtotime($updatedAt);
		if($differenceInSeconds > $limit)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}