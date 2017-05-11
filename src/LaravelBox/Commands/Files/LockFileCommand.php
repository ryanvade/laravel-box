<?php

namespace LaravelBox\Commands\Files;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use LaravelBox\Factories\ApiResponseFactory;

class LockFileCommand extends AbstractFileCommand
{
    public function __construct(string $token, string $path)
    {
        $this->token = $token;
        $this->fileId = parent::getFileId($path);
        $this->folderId = parent::getFolderId(dirname($path));
    }

    public function execute()
    {
        $token = $this->token;
        $fileId = $this->fileId;
        $url = "https://api.box.com/2.0/files/${fileId}";
        $body = [
            'lock' => [
                'type' => 'lock',
                //TODO Lock Expiration Date
                //TODO Lock Download Prevented
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
