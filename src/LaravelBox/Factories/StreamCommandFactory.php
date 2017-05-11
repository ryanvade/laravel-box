<?php

namespace LaravelBox\Factories;
use \LaravelBox\Commands\Streams\UploadStreamCommand;

class StreamCommandFactory {
    public static function build()
    {
        if(func_num_args() < 1)
        return null;

        $command = func_get_arg(func_num_args()  - 1);
        switch ($command) {
            case 'upload':
                $token = func_get_arg(0);
                $contents = func_get_arg(1);
                $remotePath = func_get_arg(2);
                return new UploadStreamCommand($token, $contents, $remotePath);
                break;

            default:
                return null;
        }
    }
}
