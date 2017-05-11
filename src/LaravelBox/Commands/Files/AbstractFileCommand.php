<?php

namespace LaravelBox\Commands\Files;

use LaravelBox\Commands\AbstractCommand;

abstract class AbstractFileCommand extends AbstractCommand
{
    protected $fileId;
    protected $parentId;
}
