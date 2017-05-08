<?php

use GuzzleHttp\Psr7\Response;

namespace LaravelBox\Commands\Files;

class GetFileInformationCommand extends AbstractFileCommand
{
    private $storageLocation;

    public function __construct(string $token, string $fileId, string $storageLocation)
    {
        parent::__construct($token, $fileId);
        $this->storageLocation = $storageLocation;
    }

    private function execute()
    {
        try {
            $url = "https://api.box.com/2.0/files/${$this->fileId}/content";
            $handle = fopen($this->storageLocation, 'w');
            $options = [
              'sink' => $handle,
              'headers' => [
                'Authorization' => "Bearer ${$this->token}",
              ],
            ];
            $client = parent::getInstance();

            return $client->get($url, $options);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getResponse()
    {
        $resp = $this->execute();
        $status = [];
        if (!$resp instanceof Response) {
            $status['success'] = 'error';
        } else {
            $status['success'] = $resp->getReasonPhrase();
            $status['status-code'] = $resp->getStatusCode();
            $status['body'] = $resp->getBody();
        }

        return $status;
    }
}
