<?php

namespace LaravelBox\Commands\Files;

class ToggleFileLockCommand extends AbstractFileCommand
{
    public function __construct(string $token, string $path)
    {
        parent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->token}";
        $body = [
            'lock' => [
                'type' => 'lock',
                //TODO Lock Expiration Date
                //TODO Lock Download Prevented
            ],
        ];
        $options = [
            'body' => $body,
            'headers' => [
                'Authorization' => "Bearer ${$this->token}",
            ],
        ];
        try {
            $client = new Client();
            $req = $client->request('PUT', $url, $options);
            //TODO Return API Response
        } catch (ClientException $e) {
            //TODO Return API Response
        }
    }
}
