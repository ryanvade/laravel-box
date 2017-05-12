<?php

namespace LaravelBox;

use LaravelBox\Factories\StreamCommandFactory;
use LaravelBox\Factories\CommandFactory;

class LaravelBox
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function moveFile(string $path, string $newPath)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, $newPath, 'move');

        return $command->execute();
    }

    public function fileInformation(string $path)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, 'info');

        return $command->execute();
    }

    public function fileDownload(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($this->token, $localPath, $remotePath, 'download');

        return $command->execute();
    }

    public function fileStreamDownload(string $remotePath)
    {
        $command = StreamCommandFactory::build($this->token, $remotePath, 'download');

        return $command->execute();
    }

    public function uploadFile(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($this->token, $localPath, $remotePath, 'upload');

        return $command->execute();
    }

    public function uploadContents($contents, string $remotePath)
    {
        $command = StreamCommandFactory::build($this->token, $contents, $remotePath, 'upload');

        return $command->execute();
    }

    public function uploadFileVersion(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($this->token, $localPath, $remotePath, 'upload-version');

        return $command->execute();
    }

    public function uploadContentsVersion($contents, string $remotePath)
    {
        $command = StreamCommandFactory::build($this->token, $contents, $remotePath, 'upload-version');

        return $command->execute();
    }

    public function uploadStreamContents($resource, string $remotePath)
    {
        $command = StreamCommandFactory::build($this->token, $resource, $remotePath, 'upload-stream');

        return $command->execute();
    }

    public function uploadStreamContentsVersion($resource, string $remotePath)
    {
        $command = StreamCommandFactory::build($this->token, $resource, $remotePath, 'upload-stream-version');

        return $command->execute();
    }

    public function preflightCheck(string $localPath, string $remotePath)
    {
        $command = CommandFactory::createFileCommand($this->token, $localPath, $remotePath, 'flight-check');

        return $command->execute();
    }

    public function deleteFile(string $path)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, 'delete');

        return $command->execute();
    }

    public function copyFile(string $path, string $newPath)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, $newPath, 'copy');

        return $command->execute();
    }

    public function lockFile(string $path)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, 'file-lock');

        return $command->execute();
    }

    public function unLockFile(string $path)
    {
        //TODO Does not actually Unlock because bad API
        $command = CommandFactory::createFileCommand($this->token, $path, 'file-unlock');

        return $command->execute();
    }

    public function downloadFileThumbnail(string $path, string $outPath, string $extension = 'png')
    {
        $command = CommandFactory::createFileCommand($this->token, $path, $outPath, $extension, 'thumbnail');

        return $command->execute();
    }

    public function fileThumbnailStream(string $path, string $extension = 'png')
    {
        $command = StreamCommandFactory::build($this->token, $path, $extension, 'thumbnail');

        return $command->execute();
    }

    public function fileEmbeddedLink(string $path)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, 'embed-link');

        return $command->execute();
    }

    public function fileComments(string $path)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, 'comments');

        return $command->execute();
    }

    public function fileTasks(string $path)
    {
        $command = CommandFactory::createFileCommand($this->token, $path, 'tasks');

        return $command->execute();
    }
}
