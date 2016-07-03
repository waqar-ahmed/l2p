<?php

namespace App\Services;

use \Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class RequestManagerGuzzle implements L2pRequestManager {

    //Object to execute http request on L2P Server
    private $client;

    function __construct() {
        $this->client = new Client(["base_uri" => Config::get('l2pconfig.api_url')]);
    }

    /*
     * Send http requests to url
     */

    public function executeRequest($method, $subUrl, $params, $url = null, $timeout = 10.0) {
        if(isset($url)) {
            $this->client = new Client(["base_uri" => $url]);
        }
        $errorMessage = 'Error occurred while sending a request to server';
        try {
            $response =  $this->client->request($method, $subUrl, $params);
            return array('code' => $response->getStatusCode(), 'body' => $response->getBody(),
                'reason_phrase' => $response->getReasonPhrase(), 'headers' => $response->getHeaders());
        } catch (TransferException $e) {
            //TODO: Log exceptions here
            if ($e->hasResponse()) {
                $jsonResponse =  json_decode($e->getResponse()->getBody()->getContents(), true);
                if(!is_null($jsonResponse)) {
                    if(array_key_exists('Status', $jsonResponse) && false === $jsonResponse['Status']) {
                        $errorMessage = $jsonResponse['errorDescription'];
                    } else {
                        $errorMessage = $e->getResponse()->getBody()->getContents();
                    }
                    return array('code' => $e->getResponse()->getStatusCode(), 'body' => $errorMessage,
                    'reason_phrase' => $e->getResponse()->getReasonPhrase(), 'headers' => $e->getResponse()->getHeaders());
                }
            }
            $errorMessage = $e->getMessage();
        }
        return array('code' => 101, 'body' => $errorMessage);
    }

}
