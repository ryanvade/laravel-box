<?php

namespace LaravelBox\Api;

use LaravelBox\Config\ConfigInterface;

abstract class Api implements ApiInterface
{
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getConfig()
    {
        return $this->config;
    }

    protected function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getFileId(string $path)
    {
        if (basename($path) == '') {
            return -1;
        }

        $folder = dirname($path);
        $folderId = 0; // base case of root
        if ($folder != '/' && $folder != '.') {
            // if not root
            $folderId = $this->getFolderId($folder);
        }
        if (($item_count = $this->getFolderItemCount($folderId)) < 0) {
            return -1;
        }
        $fileId = -1;
        $offset = 0;
        do {
            $limit = ($item_count < 1000 + $offset) ? $item_count - $offset : 1000;
            $items = $this->getFolderItems($folderId, $offset, $limit);
            foreach ($items->entries as $item) {
                if ($item->name == basename($path)) {
                    $fileId = $item->id;
                }
            }
            $offset += $limit;
        } while ($offset < $item_count && $fileId == -1);

        return $fileId;
    }

    protected function getFolderId(string $path)
    {
        if (dirname($path) == '.') {
            return -1;
        }

        if ($path === '/' || $path === '') {
            $this->cacheId(0, $path);

            return 0;
        }
        $exp = explode('/', $path);
        $exp_cnt = count($exp);

        return $this->recursiveFolderIdFind(0, implode('/', array_slice($exp, 1)), $exp[$exp_cnt - 1]);
    }

    protected function fileExists(string $fileId)
    {
        try {
            $url = $this->config->baseUrl(). "files/${fileId}";
            $options = [
                'headers' => [
                    'Authorization' => $this->config->getAuthHeader(),
                ],
            ];
            $resp = $this->config->client->request('GET', $url, $optons);

            return $resp->getStatusCode() < 400;
        } catch (ClientException $e) {
            return false;
        }
    }

    protected function folderExists(string $folderId)
    {
        try {
            $url = $this->config->baseUrl() . "folders/${folderId}";
            $options = [
                'headers' => [
                    'Authorization' => $this->config->getAuthHeader(),
                ],
            ];

            $resp = $this->config->client->request('GET', $url, $optons);

            return $resp->getStatusCode() < 400;
        } catch (ClientException $e) {
            return false;
        }
    }

    protected function getFolderItemCount(string $folderId)
    {
        if ($folderId < 0) {
            return -1;
        }

        $url = $this->config->baseUrl() . "folders/${folderId}";
        $options = [
          'headers' => [
              'Authorization' => $this->config->getAuthHeader(),
          ],
      ];
        try {
            $req = $this->config->client->request('GET', $url, $options);
            $json = json_decode($req->getBody());

            return $json->item_collection->total_count;
        } catch (ClientException $e) {
            return -1;
        }
    }

    protected function getFolderItems(string $folderId, int $offset, int $limt)
    {
        $limit_min = 100;
        $limit_max = 1000;
        $url = $this->config->baseUrl() . "folders/${folderId}/items";
        $options = [
          'headers' => [
              'Authorization' => $this->config->getAuthHeader(),
          ],
          'query' => [
              'fields' => 'name',
              'offset' => ($offset < 0) ? 0 : $offset,
              'limit' => ($limit < 0) ? $limit_min : ($limit > $limit_max) ? $limit_max : $limit,
          ],
      ];
        try {
            $req = $this->config->client->request('GET', $url, $options);

            return json_decode($req->getBody());
        } catch (Exception $e) {
            return json_decode(json_encode([]));
        }
    }

    protected function recursiveFolderIdFind(string $search_folder_id, string $search_path, string $final_folder)
    {
        $exp = explode('/', $search_path);
        $find_folder = $exp[0];
        if (($item_count = $this->getFolderItemCount($search_folder_id)) < 0) {
            return -1;
        }
        $folderId = -1;
        $offset = 0;
        do {
            $limit = ($item_count < 1000 + $offset) ? $item_count - $offset : 1000;
            $items = $this->getFolderItems($search_folder_id, $offset, $limit);
            foreach ($items->entries as $item) {
                if ($item->name == $find_folder) {
                    $id = $item->id;
                    if ($item->name == $final_folder) {
                        return $id;
                        break; // Just to be safe
                    }
                    $folderId = $this->recursiveFolderIdFind($id, implode('/', array_slice($exp, 1)), $final_folder);
                    break;
                }
            }
            $offset += $limit;
        } while ($offset < $item_count);

        return $folderId;
    }
}
