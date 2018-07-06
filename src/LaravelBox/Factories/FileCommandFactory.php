<?php

namespace LaravelBox\Factories;

use LaravelBox\Commands\Files\MoveFileCommand;
use LaravelBox\Commands\Files\CopyFileCommand;
use LaravelBox\Commands\Files\FileTasksCommand;
use LaravelBox\Commands\Files\UnLockFileCommand;
use LaravelBox\Commands\Files\UploadFileCommand;
use LaravelBox\Commands\Files\DeleteFileCommand;
use LaravelBox\Commands\Files\DownloadFileCommand;
use LaravelBox\Commands\Files\FileCommentsCommand;
use LaravelBox\Commands\Files\FileThumbnailCommand;
use LaravelBox\Commands\Files\PreflightCheckCommand;
use LaravelBox\Commands\Files\FileEmbeddedLinkCommand;
use LaravelBox\Commands\Files\UploadFileVersionCommand;
use LaravelBox\Commands\Files\GetFileInformationCommand;
use LaravelBox\Commands\Files\TagFileCommand;

class FileCommandFactory
{
    public static function build()
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
            if (func_num_args() < 4) {
                return null;
            }
            $token = func_get_arg(0);
            $local = func_get_arg(1);
            $remote = func_get_arg(2);

            return new DownloadFileCommand($token, $local, $remote);
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
            $path = func_get_arg(1);

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

            case 'file-lock':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new LockFileCommand($token, $path);
            break;

            case 'file-unlock':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new UnLockFileCommand($token, $path);
            break;

            case 'thumbnail':
            if (func_num_args() < 5) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);
            $outPath = func_get_arg(2);
            $extension = func_get_arg(3);

            return new FileThumbnailCommand($token, $path, $outPath, $extension);
            break;

            case 'embed-link':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new FileEmbeddedLinkCommand($token, $path);
            break;

            case 'collaborations':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new FileCollaborationsCommand($token, $path);
            break;

            case 'comments':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new FileCommentsCommand($token, $path);
            break;

            case 'tasks':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);

            return new FileTasksCommand($token, $path);
            break;

            case 'tag':
            if (func_num_args() < 3) {
                return null;
            }
            $token = func_get_arg(0);
            $path = func_get_arg(1);
            $tags = func_get_arg(2);

            return new TagFileCommand($token, $path, $tags);
            break;

            default:
                return null;
                break;
        }
    }
}
