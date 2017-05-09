<?php


namespace LaravelBox\Factories;

class CommandFactory
{
    public static function create(string $token, string $path, string $newPath, string $mode)
    {
        switch ($mode) {
            case 'move':
                return new MoveFileCommand($token, $path, $newPath);
                break;

            case 'copy':
                //code...
                break;

            default:
                return null;
                break;
        }
    }
}
