<?php

namespace App\Services;

use \Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class RequestManagerGuzzle implements L2pRequestManager {

    //Object to execute http request on L2P Server
    private $client;

    function __construct() {
        $this->client = new Client(["base_uri" => Config::get('l2pconfig.api_url'), 'timeout' => 0.0]);
    }    

    /*
     * Send http requests to url
     */
    public function executeRequest($method, $subUrl, $params, $url = null, $timeout = 10.0) {
        if(isset($url)) {
            $this->client = new Client(["base_uri" => $url, 'timeout' => $timeout]);
        }
        try {            
            $response =  $this->client->request($method, $subUrl, $params);        
            return array('code' => $response->getStatusCode(), 'body' => $response->getBody(), 
                'reason_phrase' => $response->getReasonPhrase(), 'headers' => $response->getHeaders());
        } catch (TransferException $e) {
            //TODO: Log exceptions here
            echo $e->getMessage();
            if ($e->hasResponse()) {
                $response =  $e->getResponse();                
               echo $response->getBody();                       
                return array('code' => $response->getStatusCode(), 'body' => $response->getBody(), 
                'reason_phrase' => $response->getReasonPhrase(), 'headers' => $response->getHeaders());//              
            }
        }
        return array('code' => 101, 'reason_phrase' => 'Error occurred while sending a request to server');
    }        

}
