<?php

namespace LaravelBox\Helpers;

use LaravelBox\Commands\AbstractCommand;

class FolderItemCount extends AbstractCommand {

    private $folderId;
    public function __construct(string $token, string $path)
    {
        $this->token = $token;
        $this->folderId = parent::getFolderId($path);
    }

    public function execute()
    {
        $token = $this->token;
        $folderId = $this->folderId;
        if($folderId < 0) {
            return -1;
        }

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
        } catch (ClientException $e) {
            return -1;
        }
    }
}
