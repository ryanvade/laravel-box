<?php

use LaravelBox\Factories\ApiResponseFactory;

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

            return ApiResponseFactory::build($req);
        } catch (ClientException $e) {
            return ApiResponseFactory::build($e);
        } catch (ServerException $e) {
            return ApiResponseFactory::build($e);
        } catch (TransferException $e) {
            return ApiResponseFactory($e);
        } catch (RequestException $e) {
            return ApiResponseFactory($e);
        }
    }
}
