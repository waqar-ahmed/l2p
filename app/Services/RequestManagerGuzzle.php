<?php

namespace App\Services;

use \Config;
use GuzzleHttp\Client;

class RequestManagerGuzzle implements L2pRequestManager {

    //Object to execute http request on L2P Server
    private $client;

    function __construct() {
        $this->client = new Client(["base_uri" => Config::get('l2pconfig.base_url'), 'timeout' => 2.0]);
    }

    public function executePostRequest($sub_url, $params) {
        $response = $this->client->request('POST', $sub_url, [
            'form_params' => $params]);

        $code = $response->getStatusCode();
        $body = $response->getBody(true);

        return array('code' => $code, 'body' => $body);
    }

    public function executeNewPostRequest($url, $sub_url, $params) {
        $client = new Client(["base_uri" => $url, 'timeout' => 2.0]);
        $response = $client->request('POST', $sub_url, ['form_params' => $params]);

        $code = $response->getStatusCode();
        $body = $response->getBody(true);

        return array('code' => $code, 'body' => $body);
    }

    public function executeRequest($method, $subUrl, $params, $url = null) {
        if(isset($url)) {
            $this->client = new Client(["base_uri" => $url, 'timeout' => 6.0]);
        }
        $response = $this->client->request($method, $subUrl, $params);

        $code = $response->getStatusCode();
        $body = $response->getBody(true);

        return array('code' => $code, 'body' => $body);
    }

}
