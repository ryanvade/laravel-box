<?php

namespace LaravelBox\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Cache\Repository as Cache;

abstract class AbstractCommand
{
    protected $token;

    abstract protected function execute();

    protected function getFileId(string $path)
    {
        if (basename($path) == '') {
            return -1;
        }
        // if (Cache::has($path)) {
        //     return Cache::get($path);
        // }
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
        // if (Cache::has($path)) {
        //     return Cache::get($path);
        // }

        if ($path === '/' || $path === '') {
            $this->cacheId(0, $path);

            return 0;
        }
        $exp = explode('/', $path);
        $exp_cnt = count($exp);

        return $this->recursiveFolderIdFind(0, implode('/', array_slice($exp, 1)), $exp[$exp_cnt - 1]);
    }

    protected function cacheId(integer $id, string $path)
    {
        // To be compatible with AWS QUEUE service, 30 minutes are used
        Cache::put($path, $id, Carbon::now()->addMinutes(30));
    }

    public function fileExists(string $fileId)
    {
        try {
            $url = "https://api.box.com/2.0/files/${fileId}";
            $options = [
                'headers' => [
                    'Authorization' => "Bearer ${$this->token}",
                ],
            ];
            $client = new Client();
            $resp = $client->request('GET', $url, $optons);

            return $resp->getStatusCode() < 400;
        } catch (ClientException $e) {
            return false;
        }
    }

    public function folderExists(string $folderId)
    {
        try {
            $url = "https://api.box.com/2.0/folders/${folderId}";
            $options = [
                'headers' => [
                    'Authorization' => "Bearer ${$this->token}",
                ],
            ];
            $client = new Client();
            $resp = $client->request('GET', $url, $optons);

            return $resp->getStatusCode() < 400;
        } catch (ClientException $e) {
            return false;
        }
    }

    private function getFolderItemCount($folderId)
    {
        if ($folderId < 0) {
            return -1;
        }
        $token = $this->token;
        $url = "https://api.box.com/2.0/folders/${folderId}";
        $options = [
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];
        try {
            $client = new \GuzzleHttp\Client();
            $req = $client->request('GET', $url, $options);
            $json = json_decode($req->getBody());

            return $json->item_collection->total_count;
        } catch (Exception $e) {
            return -1;
        }
    }

    private function getFolderItems($folderId, $offset, $limit)
    {
        $limit_min = 100;
        $limit_max = 1000;
        $token = $this->token;
        $url = "https://api.box.com/2.0/folders/${folderId}/items";
        $options = [
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
            'query' => [
                'fields' => 'name',
                'offset' => ($offset < 0) ? 0 : $offset,
                'limit' => ($limit < 0) ? $limit_min : ($limit > $limit_max) ? $limit_max : $limit,
            ],
        ];
        try {
            $client = new \GuzzleHttp\Client();
            $req = $client->request('GET', $url, $options);

            return json_decode($req->getBody());
        } catch (Exception $e) {
            return json_decode(json_encode([]));
        }
    }

    private function recursiveFolderIdFind($search_folder_id, $search_path, $final_folder)
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
