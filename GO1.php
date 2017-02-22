<?php

namespace go1\api;

use \GuzzleHttp\Client;

class GO1 extends Client {

    private $endpoint = 'https://api.go1.com/v1';
    private $clientId;
    private $clientSecret;

    private $accessToken = null;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->endpoint = $this->getConfig('endpoint');
        $this->clientId = $this->getConfig('client_id');
        $this->clientSecret = $this->getConfig('client_secret');

    }

    public function authenticate() {
        $response = $this->post($this->endpoint . "/oauth/token", [
            'json' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials'
            ]
        ]);
        $output = json_decode($response->getBody(), true);
        $this->accessToken = $output['access_token'];
    }

    public function getUsers() {
        return $this->doGet('/users');
    }

    public function getLearningObject() {
        return $this->doGet('/learning-object');
    }

    public function getEnrollments() {
        return $this->doGet('/enrolments');
    }

    public function getWebhooks() {
        return $this->doGet('/webhook');
    }

    private function doGet($path) {
        try {
            $response = $this->get($this->endpoint . $path, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken
                ]
            ]);
            return json_decode($response->getBody(), true);
        }
        catch (\Exception $e) {
            return [];
        }
    }

    private function doPost($path, $json) {
        try {
            $response = $this->post($this->endpoint . $path, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken
                ],
                'json' => $json
            ]);
            return json_decode($response->getBody(), true);
        }
        catch (\Exception $e) {
            return [];
        }
    }

}