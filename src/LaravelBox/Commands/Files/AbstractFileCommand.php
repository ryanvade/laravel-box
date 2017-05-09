<?php

use LaravelBox\Commands\AbstractCommand;

namespace LaravelBox\Comamnds\Files;

abstract class AbstractFileCommand extends AbstractCommand
{
    protected $fileId;
    protected $parentId;

    protected function __construct(string $token, string $fileId, string $parentId)
    {
        $this->fileId = $fileId;
        $this->parentId = $parentId;
        $this->token = $token;
    }
}
