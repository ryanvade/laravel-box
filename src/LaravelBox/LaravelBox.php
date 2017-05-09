<?php

use LaravelBox\Factories\CommandFactory;

namespace LaravelBox;

class LaravelBox
{
    private $token;
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function move(string $path, string $newPath)
    {
        $command = CommandFactory::create($token, $path, $newPath, 'move');
        return $command->execute();
    }
}
