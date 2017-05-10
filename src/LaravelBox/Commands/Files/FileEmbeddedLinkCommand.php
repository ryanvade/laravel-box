<?php

namespace LaravelBox\Commands\Files;

class FileEmbeddedLinkCommand extends AbstractFileCommand
{
    public function __construct(string $token, string $path)
    {
        partent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}";
        $options = [
            'query' => [
                'fields' => 'expiring_embed_link',
            ],
            'headers' => [
                'Authorization' => "Bearer ${$this->token}",
            ],
        ];

        try {
            $client = new Client();
            $req = $client->request('GET', $url, $options);
                // TODO Return API Response
        } catch (ClientException $e) {
            // TODO Return API Response
        }
    }
}
