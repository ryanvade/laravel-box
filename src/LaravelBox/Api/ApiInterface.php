<?php

namespace LaravelBox\Api;

use LaravelBox\Config\ConfigInterface;

interface ApiInterface
{
    protected function getConfig();
    protected function setConfig(ConfigInterface $config);
    protected function getFileId(string $path);
    protected function getFolderId(string $path);
    protected function fileExists(string $fileId);
    protected function folderExists(string $folderId);
    protected function getFolderItemCount(string $folderId);
    protected function getFolderItems(string $folderId, int $offset, int $limit);
    protected function recursiveFolderIdFind(string $search_folder_id, string $search_path, string $final_folder);
}
