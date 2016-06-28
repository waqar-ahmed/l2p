<?php

namespace App\Services;

use \Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class RequestManagerGuzzle implements L2pRequestManager {

    //Object to execute http request on L2P Server
    private $client;

    function __construct() {
        $this->client = new Client(["base_uri" => Config::get('l2pconfig.api_url'), 'timeout' => 10.0]);
    }    

    /*
     * Send http requests to url
     */
    public function executeRequest($method, $subUrl, $params, $url = null, $timeout = 0.0) {
        if(isset($url)) {
            $this->client = new Client(["base_uri" => $url, 'timeout' => $timeout]);
        }
        $errorMessage = 'Error occurred while sending a request to server';
        try {
            $response =  $this->client->request($method, $subUrl, $params);        
            return array('code' => $response->getStatusCode(), 'body' => $response->getBody(), 
                'reason_phrase' => $response->getReasonPhrase(), 'headers' => $response->getHeaders());
        } catch (TransferException $e) {
            //TODO: Log exceptions here
//            echo $e->getMessage();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $jsonResponse =  json_decode($response->getBody()->getContents(), true);    
                if(false === $jsonResponse['Status']) {
                    $errorMessage = $jsonResponse['errorDescription'];
                } else {
                    $errorMessage = $response->getBody()->getContents();
                }
                return array('code' => $response->getStatusCode(), 'body' => $errorMessage, 
                'reason_phrase' => $response->getReasonPhrase(), 'headers' => $response->getHeaders());            
            } 
            $errorMessage = $e->getMessage();
        }
        return array('code' => 101, 'body' => $errorMessage);
    }        

}
