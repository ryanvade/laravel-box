<?php

namespace LaravelBox\Factories;

class CommandFactory
{
    public static function createFileCommand()
    {
        if (func_num_args() <= 0) {
            return null;
        }
        $mode = func_get_arg(func_num_args() - 1);
        switch ($mode) {
            case 'move':
                if (func_num_args() < 4) {
                    return null;
                }
                $token = func_get_arg(0);
                $path = func_get_arg(1);
                $newPath = func_get_arg(2);

                return new MoveFileCommand($token, $path, $newPath);
                break;

            case 'info':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new GetFileInformationCommand($token, $path);
                break;

            case 'download':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new DownloadFileCommand($token, $path);
                break;

            case 'upload':
            if (func_num_args() < 4) {
                return null;
            }
            $token = func_get_arg(0);
            $localPath = func_get_arg(1);
            $remotePath = func_get_arg(2);

            return new UploadFileCommand($token, $localPath, $remotePath);
                break;

            case 'upload-version':
            if (func_num_args() < 4) {
                return null;
            }
            $token = func_get_arg(0);
            $localPath = func_get_arg(1);
            $remotePath = func_get_arg(2);

            return new UploadFileVersionCommand($token, $localPath, $remotePath);
                break;

            case 'flight-check':
            if (func_num_args() < 4) {
                return null;
            }
            $token = func_get_arg(0);
            $localPath = func_get_arg(1);
            $remotePath = func_get_arg(2);

            return new PreflightCheckCommand($token, $localPath, $remotePath);
                break;

            case 'delete':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(2);

            return new DeleteFileCommand($token, $path);
                break;

            case 'copy':
            if (func_num_args() < 4) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);
            $newPath = func_get_arg(2);

            return new CopyFileCommand($token, $path, $newPath);
            break;
            default:
                return null;
                break;
        }
    }
}
