<?php

namespace LaravelBox\Factories;

use LaravelBox\Commands\Folders\DeleteFolderCommand;
use LaravelBox\Commands\Folders\CreateFolderCommand;

class FolderCommandFactory
{
    public static function build()
    {
        if (func_num_args() <= 0) {
            return null;
        }
        $mode = func_get_arg(func_num_args() - 1);
        switch ($mode) {
            case 'delete':
                $token = func_get_arg(0);
                $path = func_get_arg(1);
                $recursive = func_get_arg(2);

                return new DeleteFolderCommand($token, $path, $recursive);
                break;

            case 'create':
                $token = func_get_arg(0);
                $path = func_get_arg(1);

                return new CreateFolderCommand($token, $path);
                break;

            default:
                return null;
                break;
        }
    }
}
