<?php

namespace LaravelBox\Commands\Folders;

use LaravelBox\Commands\AbstractCommand;

abstract class AbstractFolderCommand extends AbstractCommand
{
    protected $folderId;
    protected $parentId;
}
