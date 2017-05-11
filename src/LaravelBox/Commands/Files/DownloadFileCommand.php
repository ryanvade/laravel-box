<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class DownloadFileCommand extends AbstractFileCommand
{
    private $downloadPath;

    public function __construct(string $token, string $local, string $remote)
    {
        $this->downloadPath = $local;
        $this->token = $token;
        $this->fileId = parent::getFileId($remote);
        $this->folderId = parent::getFolderId(dirname($remote));
    }

    public function execute()
    {
        $fileId = $this->fileId;
        $token = $this->token;
        $url = "https://api.box.com/2.0/files/${fileId}/content";
        $options = [
            'sink' => fopen($this->downloadPath, 'w'),
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];
        try {
            $client = new Client();
            $resp = $client->request('GET', $url, $options);

            return ApiResponseFactory::build($resp);
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
