<?php

namespace LaravelBox\Commands\Files;

class FileTasksCommand extends AbstractFileCommand
{
    public function __construct(string $token, string $path)
    {
        parent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}/tasks";
        $options = [
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
