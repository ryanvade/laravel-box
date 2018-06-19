<?php

namespace LaravelBox\Config;

use GuzzleHttp\Client;

interface ConfigInterface
{
    protected function baseUrl();

    protected function getApiVersion();
    protected function setApiVersion(string $apiVersion);

    protected function getApiKey();
    protected function setApiKey(string $apiKey);

    protected function getClient();
    protected function setClient(Client $client);

    protected function getAuthHeader();
}
