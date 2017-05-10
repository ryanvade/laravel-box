<?php

namespace LaravelBox\Commands\Files;

class FileThumbnailCommand extends AbstractFileCommand
{
    private $extension;
    private $outPath;

    public function __construct(string $token, string $path, string $outPath, string $extension)
    {
        $this->extension = $extension;
        $this->outPath = $outPath;
        parent::__construct($token, $this->getFileId(basename($path)), $this->getFolderId(dirname($path)));
    }

    public function execute()
    {
        $url = "https://api.box.com/2.0/files/${$this->token}/thumbnail.${$this->extension}";
        $options = [
            'sink' => fopen($this->outPath, 'w'),
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
