<?php

use LaravelBox\Commands\CommandInterface;

namespace LaravelBox\Commands\Files;

abstract class AbstractFileCommand implements CommandInterface
{
    protected $token;
    protected $fileId;
    private static $clientInstance = null;

    abstract protected function execute();

    abstract protected function getResult();

    public function __construct(string $token, string $fileId)
    {
        $this->token = $token;
        $this->fileId = $fileId;
    }

    protected function getInstance()
    {
        if ($this->clientInstance == null) {
            $this->clientInstance = new Client();
        }

        return $this->clientInstance;
    }
}
