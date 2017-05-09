<?php

namespace LaravelBox\Commands\Files;

class MoveFileCommand extends AbstractFileCommand
{
    private $newPath;
    private $oldPath;

    public function __construct(string $token, string $path, string $newPath)
    {
        $this->oldPath = $path;
        $this->newPath = $newPath;
        parent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->fileId}";
        $body = [
            'name' => basename($this->newPath),
            'parent' => [
                'id' => $this->getFolderId(dirname($newPath)),
            ],
        ];
        $options = [
            'header' => [
            'Authorization' => "Bearer ${$this->token}",
            ],
            'body' => $body,
        ];

        try {
            $client = new Client();
            $req = $client->request('PUT', $url, $headers);
            // TODO return API Response
        } catch (ClientException $e) {
            // TODO return API Response
        }
    }
}
