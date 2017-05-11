<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class FileThumbnailCommand extends AbstractFileCommand
{
    private $extension;
    private $outPath;

    public function __construct(string $token, string $path, string $outPath, string $extension)
    {
        $this->extension = $extension;
        $this->outPath = $outPath;
        $this->token = $token;
        $this->fileId = parent::getFileId($path);
        $this->folderId = parent::getFolderId(dirname($path));
    }

    public function execute()
    {
        $token = $this->token;
        $fileId = $this->fileId;
        $folderId = $this->folderId;
        $extension = $this->extension;
        $url = "https://api.box.com/2.0/files/${fileId}/thumbnail.${extension}";
        $options = [
            'sink' => fopen($this->outPath, 'w'),
            'headers' => [
                'Authorization' => "Bearer ${token}",
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
