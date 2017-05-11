<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class MoveFileCommand extends AbstractFileCommand
{
    private $newPath;
    private $oldPath;

    public function __construct(string $token, string $path, string $newPath)
    {
        $this->oldPath = $path;
        $this->newPath = $newPath;
        $this->token = $token;
        $this->fileId = parent::getFileId($path);
        $this->folderId = parent::getFolderId(dirname($path));
    }

    public function execute()
    {
        $fileId = $this->fileId;
        $token = $this->token;
        $url = "https://api.box.com/2.0/files/${fileId}";
        $body = [
            'name' => basename($this->newPath),
            'parent' => [
                'id' => $this->getFolderId(dirname($this->newPath)),
            ],
        ];
        $options = [
            'headers' => [
            'Authorization' => "Bearer ${token}",
            ],
            'body' => json_encode($body),
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $req = $client->request('PUT', $url, $options);

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
