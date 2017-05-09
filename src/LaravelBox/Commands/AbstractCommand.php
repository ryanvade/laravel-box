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
        if (Cache::has($path)) {
            return Cache::get($path);
        }
        // NOT IMPLEMENTED YET
        return -1;
    }

    protected function getFolderId(string $path)
    {
        if (Cache::has($path)) {
            return Cache::get($path);
        }
        // NOT IMPLEMENTED YET
        return -1;
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
}
