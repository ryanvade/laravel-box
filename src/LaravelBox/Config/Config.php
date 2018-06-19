<?php

namespace LaravelBox\Config;

use GuzzleHttp\Client;

class Config implements ConfigInterface
{
    private $apiVersion;
    private $apiKey;
    private $client;

    public function __construct($apiKey = null, $apiVersion = null, $client = null)
    {
        $this->apiKey = $apiKey ?: getenv('BOX_API_KEY');
        $this->apiVersion = $apiVersion ?: getenv('BOX_API_VERSION') ?: '2.0';
        $this->client = $client ?: new Client(['base_url' => $this->baseUrl()]);
    }

    public function baseUrl()
    {
        return "https://api.box.com/" . $this->getApiVersion() . "/";
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function setApiVersion(string $apiVersion)
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getClient()
    {
        return $this->config->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    public function getAuthHeader() {
      return "Bearer " . $this->getApiKey();
    }
}
