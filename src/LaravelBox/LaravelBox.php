<?php

/**
 * @package LaravelBox
 * @version 0.0.4
 * @author Ryan Owens
 * @license MIT
 */

namespace LaravelBox;

class LaravelBox
{
    const VERSION = '0.0.4';

    private $config;

    public function __construct($apiKey = null, $apiVersion = null, $client = null)
    {
        $this->config = new Config($apiKey, $apiVersion, $client);
    }

    public function __call($method, array $paramaters)
    {
        return $this->getApiOperation($method);
    }

    protected function getApiOperation($method)
    {
        $class = "\\LaravelBox\\Api\\".ucwords($method);

        // http://php.net/manual/en/class.reflectionclass.php
        if (class_exists($class) && ! (new ReflectionClass($class))->isAbstract()) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("Undefined Method " . $method);
    }
}
