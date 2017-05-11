<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class CopyFileCommand extends AbstractFileCommand
{
    private $newPath;

    public function __construct(string $token, string $path, string $newPath)
    {
        $this->newPath = $newPath;
        $this->token = $token;
        $this->fileId = parent::getFileId($path);
        $this->folderId = parent::getFolderId(dirname($path));
    }

    public function execute()
    {
        $token = $this->token;
        $fileId = $this->fileId;
        $folderId = parent::getFolderId(dirname($this->newPath));
        echo "FileID ${fileId}\n";
        echo "FolderID ${folderId}\n";
        $url = "https:/api.box.com/2.0/files/${fileId}/copy";
        $body = [
            'parent' => [
                'id' => "${folderId}",
            ],
        ];
        $options = [
            'body' => json_encode($body),
            'headers' => [
                'Authorization' => "Bearer ${token}",
            ],
        ];
        try {
            $client = new Client();
            $req = $client->request('POST', $url, $options);

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
