<?php

namespace LaravelBox\Commands\Files;

class DownloadFileCommand extends AbstractFileCommand
{
    private $downloadPath;

    public function __construct(string $token, string $path, string $downloadPath)
    {
        $this->downloadPath = $downloadPath;
        parent::_construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}/content";
        $optons = [
            'sink' => fopen($this->downloadPath, 'w'),
            'headers' => [
                'Authorization' => "Bearer ${$this->token}",
            ],
        ];
        try {
            $client = new Client();
            $resp = $client->request('GET', $url, $options);
            // TODO return API Response
        } catch (ClientException $e) {
            // TODO return API Response
        }
    }
}
