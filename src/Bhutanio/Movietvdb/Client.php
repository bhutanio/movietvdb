<?php

namespace Bhutanio\Movietvdb;

use GuzzleHttp\Client as GuzzleClient;

abstract class Client
{
    protected $guzzle;

    protected $apiUrl;

    protected $apiKey;

    protected $apiSecure = false;

    public function __construct($apiUrl, $apiKey = null)
    {
        $this->apiUrl = ($this->apiSecure ? 'https://' : 'http://').$apiUrl;
        $this->apiKey = $apiKey;
        $this->guzzle = new GuzzleClient();
    }

    public function request($url, array $options = [])
    {
        $response = $this->guzzle->request('GET', $url, $options);
        $this->validateStatus($response->getStatusCode());

        return (string) $response->getBody();
    }

    public function toArray($string)
    {
        return json_decode($string, true);
    }

    public function toJson(array $array, $options = 0)
    {
        return json_encode($array, $options);
    }

    protected function validateImdbId($key)
    {
        if (!preg_match('/tt\\d{7}/', $key)) {
            throw new \InvalidArgumentException('Invalid IMDB ID');
        }
    }

    private function validateStatus($statusCode)
    {
        if ($statusCode < 200 && $statusCode > 299) {
            throw new \HttpResponseException('Invalid Status Code');
        }
    }
}
