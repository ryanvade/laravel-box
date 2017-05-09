<?php

use LaravelBox\Factories\CommandFactory;

namespace LaravelBox;

class LaravelBox
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function move(string $path, string $newPath)
    {
        $command = CommandFactory::createFileCommand($token, $path, $newPath, 'move');

        return $command->execute();
    }

    public function fileInformation(string $path)
    {
        $command = CommandFactory::createFileCommand($token, $path, 'info');

        return $command->execute();
    }

    public function fileDownload(string $path)
    {
        $command = CommandFactory::createFileCommand($token, $path, 'download');

        return $command->execute();
    }

    public function uploadFile(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($token, $localPath, $remotePath, 'upload');

        return $command->execute();
    }

    public function uploadFileVersion(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($token, $localPath, $remotePath, 'upload-version');

        return $command->execute();
    }

    public function preflightCheck(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($token, $localPath, $remotePath, 'flight-check');

        return $command->execute();
    }

    public function deleteFile(string $path)
    {
        $command = CommandFactory::createFileCommand($token, $localPath, $remotePath, 'delete');

        return $command->execute();
    }

    public function copyFile(string $path, string $newPath)
    {
        $command = CommandFactory::createFileCommand($token, $path, $newPath, 'copy');

        return $command->execute();
    }

    public function toggleFileLock(string $path)
    {
        $command = CommandFactory::createFileCommand($token, $path, 'toggle-lock');

        return $command->execute();
    }
}
