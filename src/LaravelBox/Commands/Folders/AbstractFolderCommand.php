<?php

use LaravelBox\Commands\AbstractCommand;

namespace LaravelBox\Commands\Folders;

abstract class AbstractFolderCommand extends AbstractCommand
{
    protected $folderId;
    protected $parentId;

    protected function __construct(string $folderId, string $parentId)
    {
        $this->folderId = $folderId;
        $this->parentId = $parentId;
    }
}
