<?php

namespace LaravelBox\Commands\Files;

class GetFileInformationCommand extends AbstractFileCommand
{
    public function __construct(string $token, string $path)
    {
        parent::_construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = 'https://api.box.com/2.0/files/'.$this->fileId;
        $options = [
        'headers' => [
            'Authorization' => "Bearer ${$this->token}",
        ],
        ];

        try {
            $client = new Client();
            $resp = $client->request('GET', $url, $options);
            //TODO return API Response
        } catch (ClientException $e) {
            // TODO return API Response
        }
    }
}
