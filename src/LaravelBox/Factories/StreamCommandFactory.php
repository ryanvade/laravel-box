<?php

namespace LaravelBox\Factories;

use LaravelBox\Commands\Streams\UploadStreamCommand;
use LaravelBox\Commands\Streams\DownloadStreamCommand;
use LaravelBox\Commands\Streams\UploadStreamVersionCommand;
use LaravelBox\Commands\Streams\UploadStreamContentsCommand;
use LaravelBox\Commands\Streams\UploadStreamContentsVersionCommand;

class StreamCommandFactory
{
    public static function build()
    {
        if (func_num_args() < 1) {
            return null;
        }

        $command = func_get_arg(func_num_args() - 1);
        switch ($command) {
            case 'upload':
                $token = func_get_arg(0);
                $contents = func_get_arg(1);
                $remotePath = func_get_arg(2);

                return new UploadStreamCommand($token, $contents, $remotePath);
                break;

            case 'upload-version':
                $token = func_get_arg(0);
                $contents = func_get_arg(1);
                $remotePath = func_get_arg(2);

                return new UploadStreamVersionCommand($token, $contents, $remotePath);
                break;

            case 'upload-stream':
                $token = func_get_arg(0);
                $contents = func_get_arg(1);
                $remotePath = func_get_arg(2);

                return new UploadStreamContentsCommand($token, $contents, $remotePath);
                break;

            case 'upload-stream-version':
                $token = func_get_arg(0);
                $contents = func_get_arg(1);
                $remotePath = func_get_arg(2);

                return new UploadStreamContentsVersionCommand($token, $contents, $remotePath);
                break;


            case 'download':
                $token = func_get_arg(0);
                $path = func_get_arg(1);

                return new DownloadStreamCommand($token, $path);
                break;

            default:
                return null;
        }
    }
}
